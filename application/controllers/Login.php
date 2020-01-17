<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
	var $data;
	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		# if user is already logged in, then redirect him to welcome page
		if(isset($_SESSION['client']->user_id) )
		{
			redirect(base_url().'welcome/','refresh');
		}

		// Set the validation rules
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		// If the validation worked
		if ($this->form_validation->run())
		{
			$login_detail['email'] = $this->input->get_post('email');
			$login_detail['password'] = $this->input->get_post('password');
			
			if($user_detail = $this->user_model->check_login($login_detail)) // if login success
			{
				if($user_detail->deleted)
				{
					$_SESSION['msg_error'][] = 'Your account has been deleted by administrator';
				}
				else
				{
					if($user_detail->is_activated)
					{
                        $update_fields = ['last_login' => date('Y-m-d H:i:s')];
                        $user_detail->last_login = date('Y-m-d H:i:s');

                        # store user location if user has given permission
					    if(isset($_SESSION['latitude']))
                        {
                            $user_detail->latitude = $_SESSION['latitude'];
                            $user_detail->longitude = $_SESSION['longitude'];
                            $update_fields['latitude'] = $_SESSION['latitude'];
                            $update_fields['longitude'] = $_SESSION['longitude'];
                        }
						$this->user_model->update($user_detail->user_id,$update_fields);
						
						if(array_key_exists(3,$user_detail->roles)) // if user is client
						{
							# Set session here and redirect user
							$_SESSION['client'] = $user_detail;

							if($this->input->get_post('remember_me') == 1)
							{
								$_SESSION['client']->remember_me = 1;
							}
							else
							{
								$_SESSION['client']->remember_me = 0;
							}

							$redirect_url = isset($_SESSION['redirect_to_last_url']) ? $_SESSION['redirect_to_last_url'] : base_url().'welcome/';
							//my_var_dump($_SESSION);
							unset($_SESSION['redirect_to_last_url']);
							redirect($redirect_url,'location');
						}
						else
						{
							$_SESSION['msg_error'][] = 'You do not have access to this area';
						}
						
					}
					else
					{
						$_SESSION['msg_error'][] = 'Your account is not yet activated by administrator';
					}
				}
			}
			else
			{
				$_SESSION['msg_error'][] = 'Invalid login id or password';
			}
		}

		$this->load->view('login_page',$this->data);
	}

	public function signup()
    {
        # if user is already logged in, then redirect him to welcome page
        if(isset($_SESSION['client']->user_id) )
        {
            redirect(base_url().'welcome/','refresh');
        }

        // Set the validation rules
        $this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_rules('roles[]', 'Role', 'required|trim');

        // If the validation worked
        if ($this->form_validation->run())
        {
            $get_post = $this->input->get_post(null,true);

            $get_post['roles'] = is_array($this->input->get_post('roles')) ? $this->input->get_post('roles') : [];

            if($get_post['email'] != '' and $this->user_model->email_already_exists($get_post['email'], 0))
            {
                $_SESSION['msg_error'][] = 'Email address already taken...';
            }
            else
            {
                # File uploading configuration
                $upload_path = './uploads/users/';
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['encrypt_name'] = true;
                $config['max_size'] = 51200; //KB

                $this->load->library('upload', $config);

                # Try to upload file now
                if ($this->upload->do_upload('image'))
                {
                    # Get uploading detail here
                    $upload_detail = $this->upload->data();

                    $get_post['image'] = $upload_detail['file_name'];
                    $image = $get_post['image'];

                    # Get width and height and resize image keeping aspect ratio same
                    $image_path = $upload_path.$image;
                    $width = get_width($image_path);
                    $width > 800 ? resize_image2($image_path, 800, '', 'W') : '';
                    $height = get_height($image_path);
                    $height > 600 ? resize_image2($image_path, '', 600, 'H') : '';
                }
                else
                {
                    $uploaded_file_array = (isset($_FILES['image']) and $_FILES['image']['name']!='') ? $_FILES['image'] : '';

                    # Show uploading error only when the file uploading attempt exist.
                    if( is_array($uploaded_file_array) )
                    {
                        $uploading_error = $this->upload->display_errors();
                        $_SESSION['msg_error'][] = $uploading_error;
                    }
                }

                $get_post['fullname'] = $get_post['firstname'].' '.$get_post['lastname'];


                $get_post['password'] = md5($get_post['password']);

                if($user_id = $this->user_model->insert($get_post))
                {
                    $_SESSION['msg_success'][] = 'Signup successfully...';

                    $user = $this->user_model->get_user_by_id($user_id);
                    $user_id_md5 = md5($user_id);

                    $this->load->library('email');

                    # Send email to user
                    $this->email->clear(TRUE);
                    $this->email->set_mailtype("html");
                    $this->email->from(SYSTEM_EMAIL, SYSTEM_NAME);
                    $this->email->to($user->email);
                    $this->email->subject("Welcome to ".SYSTEM_NAME);
                    $this->email->message("Dear $user->fullname,
                    <br>You have successfully signed up on ".SYSTEM_NAME." 
                    <br><a href='".base_url()."login/login_with_link/$user_id_md5'>Click here to login</a>");
                    $this->email->send();

                    redirect(base_url()."login/login_with_link/$user_id_md5");
                }

            }
            redirect('login/signup/');
        }

        $this->load->view('signup_page',$this->data);
    }
	public function remember_me($user_id)
	{
		if($user_detail = $this->user_model->get_user_by_id($user_id)) // if login success
		{
            if($user_detail->deleted)
            {
                $_SESSION['msg_error'][] = 'Your account is forbidden by administration ...';
            }
            else
            {
                if($user_detail->is_activated)
                {
                    $this->user_model->update($user_detail->user_id,['last_login' => date('Y-m-d H:i:s')]);

                    # Set session here and redirect user
                    $_SESSION['client'] = $user_detail;
					$_SESSION['client']->remember_me = 1;
					
					$redirect_url = isset($_SESSION['redirect_to_last_url']) ? $_SESSION['redirect_to_last_url'] : base_url().'welcome/';
					unset($_SESSION['redirect_to_last_url']);
					//my_var_dump($redirect_url);
					redirect($redirect_url,'location');
					exit;
				}
				else
				{
					$_SESSION['msg_error'][] = 'Your account has not yet been activated by administration, please check your welcome email for activation link ...!';
				}
			}
		}
		$this->load->view('login_page',$this->data);
	}
	public function logout()
	{
		session_destroy();
		$this->load->view('logout',$this->data);
	}

    public function login_with_link()
    {
        $id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->get_post('id');

        //my_var_dump($id);
        if($user_detail = $this->user_model->get_user_by_md5_id($id)) // if login success
        {
            if($user_detail->deleted)
            {
                $_SESSION['msg_error'][] = 'Your account has been deleted by administrator';
                redirect(base_url().'login/','refresh');
                exit;
            }
            else
            {
                if($user_detail->is_activated)
                {
                    $this->user_model->update($user_detail->user_id,['last_login' => date('Y-m-d H:i:s')]);

                    # Set session here and redirect user
                    $_SESSION['client'] = $user_detail;

                    redirect(base_url().'','location');
                    exit;
                }
                else
                {
                    $_SESSION['msg_error'][] = 'Your account is not yet activated by administrator';
                    redirect(base_url().'login/','refresh');
                    exit;
                }
            }
        }
    }

    public function login_by_facebook()
    {
        $response['success'] = false;

        $facebook_id = $this->input->get_post('facebook_id');
        $email = $this->input->get_post('email');
        $firstname = $this->input->get_post('first_name');
        $lastname = $this->input->get_post('last_name');
        $fullname = $this->input->get_post('name');

        if($facebook_id)
        {
            // find this user in database
            $user = $this->user_model->facebook_id_already_exists($facebook_id);
            if($user === false)
            {
                // user sign up fields
                $data['facebook_id'] = $facebook_id;
                $data['firstname'] = $firstname;
                $data['lastname'] = $lastname;
                $data['fullname'] = $fullname;
                $data['email'] = $email;
                $data['password'] = md5('alhadaf');
                $data['is_activated'] = 1;
                $data['join_date'] = date('Y-m-d');
                $data['roles'] = [2,3]; // 1=Admin 2=Owner 3=User

                // find this user by email address
                if($email)
                {
                    $user = $this->user_model->email_already_exists($email);

                    // if user found by email, then update facebook_id only
                    if($user)
                    {
                        $this->db->where('user_id',$user->user_id);
                        $this->db->update('users',['facebook_id' => $facebook_id]);

                        $row = $user;
                        $row->roles = $this->user_model->get_user_roles($row->user_id);
                        $row->rights = $this->user_model->get_user_rights($row->user_id);
                        $row->image_url = $row->image ? base_url().'uploads/users/'.$row->image : '';

                        # Set session here and redirect user
                        $_SESSION['client'] = $row;

                        $response['success'] = true;
                    }
                }

                // insert user here
                $user_id = $this->user_model->insert($data);

                $row = $this->user_model->get_user_by_id($user_id);

                # Set session here and redirect user
                $_SESSION['client'] = $row;

                $response['success'] = true;
            }
            else
            {
                $row = $user;
                $row->roles = $this->user_model->get_user_roles($row->user_id);
                $row->rights = $this->user_model->get_user_rights($row->user_id);
                $row->image_url = $row->image ? base_url().'uploads/users/'.$row->image : '';

                # Set session here and redirect user
                $_SESSION['client'] = $row;

                $response['success'] = true;
            }
        }


        echo json_encode($response);
    }
    public function forgot_password()
    {
        if($_POST)
        {
            $email = $this->input->get_post('email');

            if($email!='')
            {
                $user = $this->user_model->email_already_exists($email);
                //my_var_dump($user);
                if($user !== false)
                {
                    if($user->is_activated)
                    {
                        $firstname = $user->firstname;
                        $lastname = $user->lastname;
                        $fullname = $user->fullname;
                        $email = $user->email;
                        $reset_password_url = base_url() . 'login/reset_password/' . md5($user->user_id);

                        # Get corresponding template for password email
                        $template = $this->template_model->get_template_by_id(2);
                        $template->title = addslashes($template->title);
                        $template->message = addslashes($template->message);
                        eval("\$template->title = \"$template->title\";"); // replace tags with their values
                        eval("\$template->message = \"$template->message\";"); // replace tags with their values

                        $this->load->library('email');

                        # Send email to user
                        $this->email->clear(TRUE);
                        $this->email->set_mailtype("html");
                        $this->email->from(SYSTEM_EMAIL, SYSTEM_NAME);
                        $this->email->to($user->email);
                        $this->email->subject($template->title);
                        $this->email->message($template->message);
                        $this->email->send();
                        $_SESSION['msg_success'][] = 'We have sent you an e-mail from where you can reset your password.';
                    }
                    else
                        $_SESSION['msg_error'][] = 'This account has been disabled.';
                }
                else
                {
                    $_SESSION['msg_error'][] = 'Account does not exist with this e-mail address.';
                }
            }
            else
                $_SESSION['msg_error'][] = 'Please enter your e-mail address';
        }

        $this->load->view('forgot_password_page',$this->data);
    }

    public function reset_password()
    {
        $id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->get_post('id');

        $user = $this->user_model->get_user_by_md5_id($id);

        //my_var_dump($_REQUEST);
        if($user)
        {
            // Set the validation rules
            $password = $this->input->get_post('password');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');
            $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required|matches[password]');

            // If the validation worked
            if ($this->form_validation->run())
            {
                $data['password'] = md5($this->input->get_post('password'));
                if($this->user_model->update($user->user_id,$data))
                {
                    $firstname = $user->firstname;
                    $lastname = $user->lastname;
                    $fullname = $user->fullname;
                    $email = $user->email;
                    $login_url = base_url() . 'login/';

                    # Get corresponding template for password email
                    $template = $this->template_model->get_template_by_id(1);
                    $template->title = addslashes($template->title);
                    $template->message = addslashes($template->message);
                    eval("\$template->title = \"$template->title\";"); // replace tags with their values
                    eval("\$template->message = \"$template->message\";"); // replace tags with their values

                    # Send email to user who's email address is in vacancy
                    $this->email->clear(TRUE);
                    $this->email->set_mailtype("html");
                    $this->email->from(SYSTEM_EMAIL, SYSTEM_NAME);
                    $this->email->to($user->email);
                    $this->email->subject($template->title);
                    $this->email->message($template->message);
                    $this->email->send();

                    $_SESSION['msg_success'][] = 'Password changed successfully.';
                    redirect(base_url());
                }
            }
        }
        else
        {
            exit('Wrong Request!');
        }

        $this->data['user'] = $user;
        $this->data['id'] = $id;

        $this->load->view('reset_password',$this->data);
    }

    public function record_location()
    {
        $get_post = $this->input->get_post(null,true);
        $user_id = isset($_SESSION['client']->user_id) ? $_SESSION['client']->user_id : 0;

        if($user_id)
        {
            $this->db->where('user_id',$user_id);
            $this->db->update('users',$get_post);
            $get_post['sql'] = $this->db->last_query();
            $_SESSION['client'] = $this->user_model->get_user_by_id($user_id);
        }
        $_SESSION['latitude'] = $get_post['latitude'];
        $_SESSION['longitude'] = $get_post['longitude'];


        echo json_encode($get_post);
    }

    public function search_autocomplete()
    {
        $city = $this->input->get_post('city');
        if($city)
        {
            $this->db->select("title as autocomplete");
            $this->db->where('city',$city);
        }
        else
        {
            $this->db->select("CONCAT(title,', ',city) as autocomplete");
            $this->db->where('city!=','');
        }


        $query = $this->db->get('stadiums');
        $result = [];

        foreach ($query->result() as $row)
        {
            $result[] = $row->autocomplete;
        }
        echo json_encode($result);
    }
}