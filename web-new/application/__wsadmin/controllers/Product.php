<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		$this->load->model('querymodel');
		$this->load->model('searchmodel');
		$this->load->config('ws_article', true);
		$this->__config = $this->config->item('ws_article');
		
		$this->load->config("ws_thumbnail", true);
		$this->path_thumbnail = $this->config->item('ws_thumbnail');

		$this->load->config('ws_generic', true);
		$this->__config_beneric = $this->config->item('ws_generic');
		
	}
	
	/** field insert mysql */
	public $path_pict = '/product/'; //name path picture
	public $path_images = 'product';
	public $module = 'product'; //name module
	public $table = 'ws_product_foo'; //name table
	public $date_create = 'ws_product_date_create';
	
	public $id = 'ws_product_id';
	public $category_id = 'ws_product_category_id';
	public $title_input = 'ws_product_title';
	public $harga_input = 'ws_product_harga';
	public $berat_input = 'ws_product_berat';
	public $diskon_input = 'ws_product_diskon';
	public $summary_input = 'ws_product_summary';
	public $desc_input = 'ws_product_desc';
	public $userfile = 'userfile';
	public $image_upload = 'ws_product_image';
	public $tags_input = 'ws_product_tags';
	public $user_create = 'ws_user_create';
	public $user_update = 'ws_user_update';
	public $status = 'ws_product_status_publish';
	public $metatitle_input = 'ws_product_metatitle';
	public $metakeyword_input = 'ws_product_metakeyword';
	public $metadesc_input = 'ws_product_metadesc';
	
	public $page = 20;
	public $count_image = 4;
	
	public $breadcumb = array('Product'); //name module
	public $id_menu = 7; 
	
	public $table_image = 'ws_product_image'; 
	
	/** end field insert mysql */
	
	function index($null = null, $page = null){
		
		$offset = !empty($page) ? $this->page * ($page - 1) : 0;
		$this->product($offset, $page);
	
	}
	
	function product($offset, $page){
				
		if($this->session->userdata('username') == FALSE) login_page(); //cek session
		
		$ses_name = $this->session->userdata('username');
		if($ses_name['ws_user_acces'] == TRUE) error_page();
		
		if(isset($page) && !empty($page)) $ws_result['row'] = no_record($param = array($this->page, $page));
	
		//pagging
		$config['base_url'] = base_url(url_admin().$this->module.'/page');
		$config['total_rows'] = $this->querymodel->count_all_num_rows($this->table);
		$config['per_page'] = $this->page;
		$config['first_url'] = '1';
				
		$config['use_page_numbers'] = TRUE;
		
		$config['full_tag_open'] = '<div><ul class="pagination">';
		$config['full_tag_close'] = '</ul></div>';
		
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '<li>';
		
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '<li>';
		
		$config['next_link'] = '&gt;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '<li>';
		
		$config['prev_link'] = '&lt;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '<li>';
		
		$config['cur_tag_open'] = '<li class="active"><a href="javascrip::void();">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';


		$this->pagination->initialize($config);
		
		$ws_result['pagination'] = $this->pagination->create_links();
		
		
		$ws_result['data'] = $this->querymodel->queryRecord($this->page, $offset, $this->table);
		
		$ws_result['head_title'] = array('No'
								,'Date Create'
								,'Title'
								,'<center>Status</center>'
								,'<center>Edit</center>'
								,'<center>'.checkall_box().'</center>'
							);

		$forms['block_form'] = $this->load->view('module/product/block_list', $ws_result, true);
		$forms['title'] = $this->module;
		$view = 'right/views';

		echo $this->template($forms, $view);
		
	}
	
	function add($data = null, $err = null){
		
		if($this->session->userdata('username') == FALSE ) login_page();  //cek session
		
		isset($data[$this->title_input]) ?  $title_input = $data[$this->title_input]  : '' ;
		isset($data[$this->category_id]) ?  $category_id = serialize($data[$this->category_id])  : '' ;
		isset($data[$this->desc_input]) ? $desc_input = $data[$this->desc_input] : '' ;
		isset($data[$this->harga_input]) ? $harga_input = $data[$this->harga_input] : '' ;
		isset($data[$this->berat_input]) ? $berat_input = $data[$this->berat_input] : '' ;
		isset($data[$this->diskon_input]) ? $diskon_input = $data[$this->diskon_input] : '' ;
		isset($data[$this->tags_input]) ? $tags_input = $data[$this->tags_input] : '' ;
		isset($data[$this->metatitle_input]) ? $metatitle_input = $data[$this->metatitle_input] : '' ;
		isset($data[$this->metakeyword_input]) ? $metakeyword_input = $data[$this->metakeyword_input] : '' ;
		isset($data[$this->metadesc_input]) ? $metadesc_input = $data[$this->metadesc_input] : '' ;
		
		$form['post'] = '/insert/post';
		$form['title'] = 'Post New Product';
		$form['form'] = array(
					'module' => $this->module
					,'title_box' => input_box(array('id' => $this->title_input
													,'placeholder'=>"product name"
													,'maxlength'=>"70"
													,'class' => 'validate[required, maxSize[70]] col-xs-10 col-sm-10 limited'
													,'name'	=> $this->title_input
													,'value' => set_value($this->title_input, isset($title_input) ? $title_input : '')), $label = 'Product Name *')
					 
					,'category' => select_multi_box_search($name = $this->category_id.'[]'
												,$this->querymodel->get_category()
												,serialize(set_value($this->category_id, isset($this->category_id) ? $this->category_id : ''))
												,'Category *')

					,'desc_box' => $this->load->view('module/global/tinymce/tinymce', array('label' => 'Description *'
																							,'name' => $this->desc_input
																							,'set_value' => isset($desc_input) ? $desc_input : ''
																							,'config_name' =>'ws_article'),
																						true)
					
					,'harga' => input_box(array('id' => $this->harga_input
													,'placeholder'=>"Price"
													,'class' => 'validate[required, custom[number]] col-xs-10 col-sm-10'
													,'name'	=> $this->harga_input
													,'value' => set_value($this->harga_input, isset($harga_input) ? $harga_input : '')), $label = 'Price *')
					 
					,'berat' => input_box(array('id' => $this->berat_input
													,'placeholder'=>"Weight"
													,'class' => 'validate[required, custom[number]] col-xs-10 col-sm-10'
													,'name'	=> $this->berat_input
													,'value' => set_value($this->berat_input, isset($berat_input) ? $berat_input : '')), $label = 'Weight *')
					 
					,'diskon' => option_box_search($name = $this->diskon_input
												,$this->querymodel->get_diskon()
												,set_value($this->diskon_input, isset($diskon_input) ? $diskon_input : '')
												,'&nbsp;%', 'Diskon')

					,'upload' => multiupload($this->count_image)
					

					,'input_tags' => input_box(array('id' => 'form-field-tags'
													,'placeholder'=>'Enter tags ...'
													,'class' => 'col-xs-10 col-sm-10'
													,'name'	=> $this->tags_input
													,'value' => set_value($this->tags_input, isset($tags_input) ? $tags_input : ''))
											,array('name' => 'Tags', 'attr' => array('for'=>'form-field-tags', 'class' => 'col-sm-3 control-label no-padding-right')))
					 
					,'option_box' => option_box($name = $this->status
												,array('No Active', 'Active')
												,isset($_POST[$this->status]) ? $_POST[$this->status] : ''
												,'Status')

					,'metatitle' => input_box(array('id' => $this->metatitle_input
													,'placeholder'=>"Meta Title"
													,'class' => 'validate[required] col-xs-10 col-sm-10'
													,'name'	=> $this->metatitle_input
													,'value' => set_value($this->metatitle_input, isset($metatitle_input) ? $metatitle_input : '')), $label = 'Meta Title')

					,'metakey' => input_box(array('id' => $this->metakeyword_input
													,'placeholder'=>"Meta Keyword"
													,'class' => 'col-xs-10 col-sm-10'
													,'name'	=> $this->metakeyword_input
													,'value' => set_value($this->metakeyword_input, isset($metakeyword_input) ? $metakeyword_input : '')), $label = 'Meta Keyword')

					,'metadesc' => input_box(array('id' => $this->metadesc_input
													,'placeholder'=>"Meta Description"
													,'maxlength'=>"170"
													,'class' => 'validate[maxSize[170]] limited col-xs-10 col-sm-10'
													,'name'	=> $this->metadesc_input
													,'value' => set_value($this->metadesc_input, isset($metadesc_input) ? $metadesc_input : '')), $label = 'Meta Description')

					,'button' => button(array('value' => 'true'
												,'type' => 'submit'
												,'class' => 'btn btn-xs btn-primary submit'
												,'content' => '<i class="ace-icon fa fa-check bigger-110"></i>&nbsp;Submit'
											)
					)
				);
		
		$form['err'] = isset($err) ? $err : '';
		$view = 'right/form';
		$forms['block_form'] = $this->load->view('module/product/block_form', $form, true);
		
		echo $this->template($forms, $view);
		
	}

	function insert($post = null){
		
		if($this->session->userdata('username') == FALSE ) login_page(); //cek session
		
		if(!empty($post) && $post == 'post'){
			
			$this->form_validation->set_rules($this->title_input, 'Porduct Name', 'trim|required');
			$this->form_validation->set_rules($this->category_id.'[]', 'Category', 'trim|required');
			$this->form_validation->set_rules($this->desc_input, 'Description', 'trim|required');
			$this->form_validation->set_rules($this->harga_input, 'Price', 'trim|required');
			$this->form_validation->set_rules($this->berat_input, 'Weight', 'trim|integer|required');
			$this->form_validation->set_rules($this->diskon_input, 'Diskon', 'trim|integer');
			$this->form_validation->set_rules($this->tags_input, 'Tags', 'trim');

			// echo'<pre/>'; print_r($_POST);  
			// echo'<pre/>'; print_r($_FILES); die(); 

			if ($this->form_validation->run() == TRUE){
				
				$date_create = time();
				$title_input = $this->security->xss_clean($this->input->post($this->title_input, TRUE));
				$category_id = $this->security->xss_clean($this->input->post($this->category_id, TRUE));
				$desc_input = $this->security->xss_clean($this->input->post($this->desc_input, TRUE));
				$harga_input = $this->security->xss_clean($this->input->post($this->harga_input, TRUE));
				$berat_input = $this->security->xss_clean($this->input->post($this->berat_input, TRUE));
				$diskon_input = $this->security->xss_clean($this->input->post($this->diskon_input, TRUE));
				$tags_input = $this->security->xss_clean($this->input->post($this->tags_input, TRUE));
				$metatitle_input = $this->security->xss_clean($this->input->post($this->metatitle_input, TRUE));
				$metakeyword_input = $this->security->xss_clean($this->input->post($this->metakeyword_input, TRUE));
				$metadesc_input = $this->security->xss_clean($this->input->post($this->metadesc_input, TRUE));
							
				$status = $this->security->xss_clean($this->input->post($this->status, TRUE));
				$data_id = $this->id;		

				foreach($_FILES['userfile'] as $key => $val){
											
					foreach($_FILES['userfile']['size'] as $k => $v){
												
							$i = 1;			
							foreach($val as $v){	
								$field_name = "userfile_".$i;	
								$_FILES[$field_name][$key] = $v;	
								$_FILES[$field_name]['number'] = $i;	
								$i++;			
							}			
					}
			
				}
									
				unset($_FILES['userfile']);				

				if(!empty($date_create)) $data[$this->date_create] = time();
				if(!empty($title_input)) $data[$this->title_input] = $title_input;
				if(!empty($category_id)) $data[$this->category_id] = serialize($category_id);
				if(!empty($desc_input)) $data[$this->desc_input] = $desc_input;
				if(!empty($harga_input)) $data[$this->harga_input] = $harga_input;
				if(!empty($berat_input)) $data[$this->berat_input] = $berat_input;
				if(!empty($diskon_input)) $data[$this->diskon_input] = $diskon_input;
				if(!empty($tags_input)) $data[$this->tags_input] = str_replace(' ', '', $tags_input);				
				if(!empty($status)) $data[$this->status] = $status;
				if(!empty($metatitle_input)) $data[$this->metatitle_input] = $metatitle_input;				
				if(!empty($metakeyword_input)) $data[$this->metakeyword_input] = $metakeyword_input;				
				if(!empty($metadesc_input)) $data[$this->metadesc_input] = $metadesc_input;				
				if(!empty($status)) $data[$this->status] = $status;
				

				$data[$this->user_create] = $this->session->userdata('username')['ws_user_username'];

				if(!empty($data)) $success = $this->querymodel->insertRecord($data
																			,$data_id
																			,$this->table
																			,'image'
																			,array('funct' => 'insertCategory', 'data' => $data[$this->category_id])
																); 
					
				if(isset($success) && !is_array($success) && empty($success['error'])) {
					
					//Insert Log
					// $get_user = $this->session->userdata('username');
					// $param_log = array();
					// $param_log['username'] = $get_user['ws_user_username'];
					// $param_log['status'] = 'ADD '.$this->module;
					// $param_log['description'] = 'Name: '.$get_user['ws_user_name'];
					// $this->logmodel->insertLog($param_log);
					//end insert log
											
					$this->session->set_flashdata('message', 'Add '.$this->module.' Success');
					redirect('../'.url_admin().$this->module.'/add');
				}else{
				
					foreach($success['error'] as $key => $val){
						
						$err[$key] = $val;
							
					}
				}
				
			}else{
			
				$err[] = form_error($this->title_input, '<span class="error">', '</span>');
				$err[] = form_error($this->category_id, '<span class="error">', '</span>');
				$err[] = form_error($this->desc_input, '<span class="error">', '</span>');
				$err[] = form_error($this->harga_input, '<span class="error">', '</span>');
				$err[] = form_error($this->berat_input, '<span class="error">', '</span>');
				$err[] = form_error($this->diskon_input, '<span class="error">', '</span>');
			
			}
			
		}

		$setval = isset($data) ? $data : '';
		$err = isset($err) ? $err : '';
		$this->add($setval, $err);
	}
	
		
	function edit($field_id=null, $data = null, $err = null){
		
		if($this->session->userdata('username') == FALSE ) login_page(); //cek session
		
		$ses_name = $this->session->userdata('username');
		if(($ses_name['ws_user_username'] != $field_id) && ($ses_name['ws_user_acces'] == TRUE)) redirect(base_url('error'), 'refresh'); //cek session
		
		$result = $this->querymodel->editRecord(array($this->id => $field_id)
												,$this->table
												,array('funct' => 'get_image', 'data' => array($this->id => $field_id), 'table' => 'ws_product_image'));
		
		$title_input = isset($result[0][$this->title_input]) ? $result[0][$this->title_input] : '';
		$category_id = isset($result[0][$this->category_id]) ? $result[0][$this->category_id] : '';
		$desc_input = isset($result[0][$this->desc_input]) ? $result[0][$this->desc_input] : '';
		$tags_input = isset($result[0][$this->tags_input]) ? $result[0][$this->tags_input] : '';
		$harga_input = isset($result[0][$this->harga_input]) ? $result[0][$this->harga_input] : '';
		$berat_input = isset($result[0][$this->berat_input]) ? $result[0][$this->berat_input] : '';
		$diskon_input = isset($result[0][$this->diskon_input]) ? $result[0][$this->diskon_input] : '';
		$metatitle_input = isset($result[0][$this->metatitle_input]) ? $result[0][$this->metatitle_input] : '';
		$metakeyword_input = isset($result[0][$this->metakeyword_input]) ? $result[0][$this->metakeyword_input] : '';
		$metadesc_input = isset($result[0][$this->metadesc_input]) ? $result[0][$this->metadesc_input] : '';
		$image = isset($result[0]['image']) ? $result[0]['image'] : '';
		$status = isset($result[0][$this->status]) ? $result[0][$this->status] : '';

		$form['update'] = '/update';
		$form['field_id']['id'] = array('name' => $this->id, 
								  'value' => $result[0][$this->id]);
		$form['title'] = 'Edit Product';
		$form['form'] = array(
					'module' => $this->module
					,'title_box' => input_box(array('id' => $this->title_input
													,'placeholder'=>"product name"
													,'class' => 'validate[required] col-xs-10 col-sm-10'
													,'name'	=> $this->title_input
													,'value' => isset($title_input) ? $title_input : ''), $label = 'Product Name *')
					 
					,'category' => select_multi_box_search($name = $this->category_id.'[]'
												,$this->querymodel->get_category()
												,isset($category_id) ? $category_id : ''
												,'Parent')

					,'desc_box' => $this->load->view('module/global/tinymce/tinymce', array('label' => 'Description *'
																							,'name' => $this->desc_input
																							,'set_value' => isset($desc_input) ? $desc_input : ''
																							,'config_name' =>'ws_article'),
																						true)
					
					,'harga' => input_box(array('id' => $this->harga_input
													,'placeholder'=>"Price"
													,'class' => 'validate[required, custom[number]] col-xs-10 col-sm-10'
													,'name'	=> $this->harga_input
													,'value' => isset($harga_input) ? $harga_input : ''), $label = 'Price *')
					 
					,'berat' => input_box(array('id' => $this->berat_input
													,'placeholder'=>"Weight"
													,'class' => 'validate[required, custom[number]] col-xs-10 col-sm-10'
													,'name'	=> $this->berat_input
													,'value' => isset($berat_input) ? $berat_input : ''), $label = 'Weight *')
					 
					,'diskon' => option_box_search($name = $this->diskon_input
												,$this->querymodel->get_diskon()
												,isset($diskon_input) ? $diskon_input : ''
												,'&nbsp;%', 'Diskon')

					,'upload' => multiupload($this->count_image, $image, $this->path_pict)
					

					,'input_tags' => input_box(array('id' => 'form-field-tags'
													,'placeholder'=>"Enter tags ..."
													,'class' => 'validate[required] col-xs-10 col-sm-10'
													,'name'	=> $this->tags_input
													,'value' => isset($tags_input) ? $tags_input : '')
											,array('name' => 'Tags', 'attr' => array('for'=>'form-field-tags', 'class' => 'col-sm-3 control-label no-padding-right')))
					 
					,'option_box' => option_box($name = $this->status
												,array('No Active', 'Active')
												,isset($status) ? $status : ''
												,'Status')

					,'metatitle' => input_box(array('id' => $this->metatitle_input
													,'placeholder'=>"Meta Title"
													,'class' => 'col-xs-10 col-sm-10'
													,'name'	=> $this->metatitle_input
													,'value' => set_value($this->metatitle_input, isset($metatitle_input) ? $metatitle_input : '')), $label = 'Meta Title')

					,'metakey' => input_box(array('id' => $this->metakeyword_input
													,'placeholder'=>"Meta Keyword"
													,'class' => 'col-xs-10 col-sm-10'
													,'name'	=> $this->metakeyword_input
													,'value' => set_value($this->metakeyword_input, isset($metakeyword_input) ? $metakeyword_input : '')), $label = 'Meta Keyword')

					,'metadesc' => input_box(array('id' => $this->metadesc_input
													,'placeholder'=>"Meta Description"
													,'class' => 'col-xs-10 col-sm-10'
													,'name'	=> $this->metadesc_input
													,'value' => set_value($this->metadesc_input, isset($metadesc_input) ? $metadesc_input : '')), $label = 'Meta Description')

					,'button' => button(array('value' => 'true'
												,'type' => 'submit'
												,'class' => 'btn btn-xs btn-primary submit'
												,'content' => '<i class="ace-icon fa fa-check bigger-110"></i>&nbsp;Submit'
											))

					,'cancel' => button(array('value' => 'true'
												,'type' => 'button'
												,'class' => 'btn btn-xs btn-success submit'
												,'content' => '<i class="ace-icon fa fa-reply bigger-110"></i>&nbsp;Cancel'
											))
				);

		$form['err'] = isset($err) ? $err : '';
		$view = 'right/form';
		$forms['block_form'] = $this->load->view('module/product/block_form', $form, true);

		echo $this->template($forms, $view);
		
	}
	
	function update(){
		
		if($this->session->userdata('username') == FALSE ) login_page(); //cek session
		
		$field_id = $this->security->xss_clean($this->input->post($this->id, TRUE));
		
		$data_ext = '';
		if(isset($field_id) && !empty($field_id)){
			
			$this->form_validation->set_rules($this->title_input, 'Porduct Name', 'trim|required');
			$this->form_validation->set_rules($this->category_id.'[]', 'Parent', 'trim|required');
			$this->form_validation->set_rules($this->desc_input, 'Description', 'trim|required');
			$this->form_validation->set_rules($this->harga_input, 'Price', 'trim|integer|required');
			$this->form_validation->set_rules($this->berat_input, 'Weight', 'trim|integer|required');
			$this->form_validation->set_rules($this->diskon_input, 'Diskon', 'trim|integer');
			
			if ($this->form_validation->run() == TRUE){
			
				$title_input = $this->security->xss_clean($this->input->post($this->title_input, TRUE));
				$category_id = $this->security->xss_clean($this->input->post($this->category_id, TRUE));
				$desc_input = $this->security->xss_clean($this->input->post($this->desc_input, TRUE));
				$harga_input = $this->security->xss_clean($this->input->post($this->harga_input, TRUE));
				$berat_input = $this->security->xss_clean($this->input->post($this->berat_input, TRUE));
				$diskon_input = $this->security->xss_clean($this->input->post($this->diskon_input, TRUE));
				$tags_input = $this->security->xss_clean($this->input->post($this->tags_input, TRUE));
				$metatitle_input = $this->security->xss_clean($this->input->post($this->metatitle_input, TRUE));
				$metakeyword_input = $this->security->xss_clean($this->input->post($this->metakeyword_input, TRUE));
				$metadesc_input = $this->security->xss_clean($this->input->post($this->metadesc_input, TRUE));

				$status = $this->security->xss_clean($this->input->post($this->status, TRUE));
				$field_id = $this->security->xss_clean($this->input->post($this->id, TRUE));

				$field['field'] = array();
				
				if(!empty($title_input)) $data[$this->title_input] = $title_input;
				if(!empty($category_id)) $data[$this->category_id] = serialize($category_id);
				if(!empty($desc_input)) $data[$this->desc_input] = $desc_input;
				if(!empty($harga_input)) $data[$this->harga_input] = $harga_input;
				if(!empty($berat_input)) $data[$this->berat_input] = $berat_input;
				if(!empty($diskon_input)) $data[$this->diskon_input] = $diskon_input;
				if(!empty($tags_input)) $data[$this->tags_input] = $tags_input;
				if(!empty($metatitle_input)) $data[$this->metatitle_input] = $metatitle_input;
				if(!empty($metakeyword_input)) $data[$this->metakeyword_input] = $metakeyword_input;
				if(!empty($metadesc_input)) $data[$this->metadesc_input] = $metadesc_input;
				if(!empty($field_id)) $data[$this->id] = $field_id;
				$data[$this->status] = $status;
				$data[$this->user_update] = $this->session->userdata('username')['ws_user_username'];
				
				$data_id = $this->id;
				
				foreach($_FILES['userfile'] as $key => $val){
			
					foreach($_FILES['userfile']['size'] as $k => $v){
						
							$i = 1;
							foreach($val as $v){
								$field_name = "userfile_".$i;
								$_FILES[$field_name][$key] = $v;
								$_FILES[$field_name]['number'] = $i;
								$i++;
							}
					}
			
				}
				
				unset($_FILES['userfile']);

				
				// check username & email
				if(!empty($data)) $success = $this->querymodel->updateRecord($data
																			, $data_id
																			, $this->table
																			,'image'
																			,array('funct' => 'updateCategory', 'data' => $data[$this->category_id], 'id'=>$field_id)); 	
																			
				if(isset($success) && empty($success['error'])){
					
					//Insert Log
					// $get_user = $this->session->userdata('username');
					// $param_log = array();
					// $param_log['username'] = $get_user['ws_user_username'];
					// $param_log['status'] = 'EDIT '.$this->module;
					// $param_log['description'] = 'Name: '.$get_user['user_name'];
					// $this->logmodel->insertLog($param_log);
					//end insert log
					
					$this->session->set_flashdata('message', 'Edit '.$this->module.' Success');
					redirect('../'.url_admin().$this->module.'/edit/'.$field_id);
				}else{
					
					foreach($success['error'] as $key => $val){
						
						$k=1;
						foreach($success['error'] as $key => $val){
							if($key == 'image_'.$k){
								$err['image_'.$k] = $val;
							}else{
								$err[] = $val;
							}
							
							$k++;
						}
						
						
					}
					
				} 

			}else{
				
				$err[] = form_error($this->title_input, '<span class="error">', '</span>');
				$err[] = form_error($this->category_id, '<span class="error">', '</span>');
				$err[] = form_error($this->desc_input, '<span class="error">', '</span>');
				$err[] = form_error($this->harga_input, '<span class="error">', '</span>');
				$err[] = form_error($this->berat_input, '<span class="error">', '</span>');
				$err[] = form_error($this->diskon_input, '<span class="error">', '</span>');
				
			}
			
		}
		
		$setval = isset($data) ? $data : '';
		$err = isset($err) ? $err : '';
		$this->edit($field_id, $setval, $err);
		
	}
	
	
	function delete(){
	
		// if($this->session->userdata('username') == FALSE ) login_page(); //cek session
	
		$del = $this->security->xss_clean($this->input->post('del', TRUE));
		
		if(isset($del)){
		
			foreach($del as $key => $val){
				
				$ex = explode(',',$val);
				$result = $this->querymodel->deleteRecord($val, null);
				
				if(isset($result)){
					//Insert Log
					// $get_user = $this->session->userdata('username');
					// $param_log = array();
					// $param_log['username'] = $get_user['user_username'];
					// $param_log['status'] = 'DELETE '.$this->module;
					// $param_log['description'] = 'Name: '.$ex[1];
					// $this->logmodel->insertLog($param_log);
					//end insert log
				}
			}
			
			if(isset($result)){
				$this->session->set_flashdata('message', 'Delete Success');
				redirect('../'.url_admin().$this->module);
			}
		}
		return $this->index();
	}
	
	function template($form, $view){
		
		$data_ex['module'] = $this->module; 

		// $form['search'] = $this->load->view('module/global/search', array(), true);
		
		$data_ex['tags'] = $this->tags();


		$wsdata['css_load'] = $this->load->view('module/global/load_css', $data_ex, true);
		$wsdata['js_load'] = $this->load->view('module/global/load_js', $data_ex, true);
		
		$param_l = array('id_menu' => $this->id_menu);
		$wsdata['block_left'] =	$this->load->view('module/global/block_left', $param_l, true);
		$wsdata['block_head'] = $this->load->view('module/global/block_head', array(), true);
		$wsdata['block_content'] = $this->load->view('module/global/block_content', $form, true);

		return $this->load->view('module/home/template', $wsdata, true);
	
	}
	
	function search(){
		
		$q = $this->security->xss_clean($this->input->get_post('q', TRUE)); //keyword
		$p = $this->security->xss_clean($this->input->get_post('p', TRUE)); //page
		$s = $this->security->xss_clean($this->input->get_post('s', TRUE)); //status
		$s = ($s=='all') ? '' : $s;
		
		$offset = !empty($p) ? $this->page * ($p - 1) : 0;
		$param = $this->__config['field_search'];
		
		$limit  = array('page' => $this->page, 'offset' => $offset);
		$keyword  = array('q' => $q, 'status' => isset($s) ? $s : '');
		$url = base_url(url_admin().$this->module.'/search?q='.$q.'&s='.$s);
		
		if(isset($offset) && !empty($offset)) $result['row'] = no_record(array($this->page, $p));
		
		$ws_result['data'] = $this->searchmodel->search_limit_data($param, $keyword, $limit, $this->table);
		//printr($result); 
		
		$ws_result['head_title'] = array('No'
								,'Date Create'
								,'Title'
								,'<center>Status</center>'
								,'<center>Edit</center>'
								,'<center>'.checkall_box().'</center>'
							);

		//pagging
		$config['base_url'] = $url;
		$config['total_rows'] = $this->searchmodel->search_limit_count($param, $keyword, $this->table);
		$config['per_page'] = $this->page;
		
		/* tambahan */
		$config['enable_query_strings'] = FALSE;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'p';
		$config['first_url'] = $url.'&p=1';
		
		$config['use_page_numbers'] = TRUE;

		$config['full_tag_open'] = '<div><ul class="pagination">';
		$config['full_tag_close'] = '</ul></div>';
		
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '<li>';
		
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '<li>';
		
		$config['next_link'] = '&gt;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '<li>';
		
		$config['prev_link'] = '&lt;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '<li>';
		
		$config['cur_tag_open'] = '<li class="active"><a href="javascrip::void();">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);
		$ws_result['pagination'] = $this->pagination->create_links();		
		
		$forms['block_form'] = $this->load->view('module/product/block_list', $ws_result, true);
		$forms['title'] = $this->module;
		$view = 'right/views';
		echo $this->template($forms, $view);
		
	}

	function tags(){
		$result = $this->querymodel->get_tags();
		sort($result);
		return $result;
	}
	
}
