<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Reclamation extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Reclamation_model');
    } 

    /*
     * Listing of reclamation
     */
    function index()
    {
        $data['reclamation'] = $this->Reclamation_model->get_all_reclamation();
        
        $data['_view'] = 'reclamation/index';
        $this->load->view('layouts/main',$data);
    }
    function index_client()
    {
        $data['reclamation'] = $this->Reclamation_model->get_all_client_reclamation($this->session->userdata('logged_in')['users_id']);
        
        $data['_view'] = 'reclamation/index';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adding a new reclamation
     */
    function add()
    {   
        if(isset($_POST) && count($_POST) > 0)     
        {   
            $params = array(
				'date_heure' => $this->input->post('date_heure'),
				'panne' => $this->input->post('panne'),
                'sujet' => $this->input->post('sujet'),
                'id_company' => $this->input->post('id_company'),
				'id_user' => $this->session->userdata('logged_in')['users_id']

            );
            
            $reclamation_id = $this->Reclamation_model->add_reclamation($params);
            redirect('reclamation/index');
        }
        else
        {   
            $this->load->model('Company_model');
			$data['all_company'] = $this->Company_model->get_all_company();         
            $data['_view'] = 'reclamation/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Editing a reclamation
     */
    function edit($id)
    {   
        // check if the reclamation exists before trying to edit it
        $data['reclamation'] = $this->Reclamation_model->get_reclamation($id);
        
        if(isset($data['reclamation']['id']))
        {
            if(isset($_POST) && count($_POST) > 0)     
            {   
                $params = array(
					'date_heure' => $this->input->post('date_heure'),
					'panne' => $this->input->post('panne'),
                    'sujet' => $this->input->post('sujet'),
                    'id_company' => $this->input->post('id_company')

                );

                $this->Reclamation_model->update_reclamation($id,$params);            
                redirect('reclamation/index');
            }
            else
            {
                $this->load->model('Company_model');
				$data['all_company'] = $this->Company_model->get_all_company();
                $data['_view'] = 'reclamation/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The reclamation you are trying to edit does not exist.');
    } 

    /*
     * Deleting reclamation
     */
    function remove($id)
    {
        $reclamation = $this->Reclamation_model->get_reclamation($id);

        // check if the reclamation exists before trying to delete it
        if(isset($reclamation['id']))
        {
            $this->Reclamation_model->delete_reclamation($id);
            redirect('reclamation/index');
        }
        else
            show_error('The reclamation you are trying to delete does not exist.');
    }
    
}
