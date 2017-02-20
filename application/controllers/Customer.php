<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* ----------------------------------------------------------------------------
 * Simple Data Grid System - by Amila
 *
 * @package     Simple Data Grid System
 * @author      Amila Tilakarathna<vishnaka23@gmail.com>
 * @copyright   Copyright (c) 2017, Amila
 * @link        http://localhost/codeCI/
 * @since       v1.0.0
 * ---------------------------------------------------------------------------- */

/**
 * Customer Controller
 *
 * @package Controllers
 */
class Customer extends CI_Controller {

     /**
     * Class Constructor
     */

    public function __construct() {
        parent::__construct();

        // loading libraries,mode,helpers,etc
        $this->load->library('form_validation');
        $this->load->model('customer_model', 'customer');
        $this->lang->load("customer", "english");
    }

    /**
     * Default callback method of the application.
     *
     * This method creates for to list all customers in dashboard.
     *
     * @param - no parameters required
     *
     *@return - no return in this method.
     */
    
    public function index() {

        $data['customers'] = $this->customer->dbGetAllCustomers();
        
        //loding header part of template
        $this->load->view('template/header', $data);
        //loding content part of template
        $this->load->view('customer_view', $data);
        //loding footer part of template
        $this->load->view('template/footer', $data);
    }
    
    /**
     * [AJAX] Add Customer information.
     *
     * This method that uses to add customer information
     *
     * @param string $_POST['customer_name'] The Customer Name.
     * @param string $_POST['customer_email'] The Customer Email'.
     * @param string|number $_POST['customer_phone'] The Customer Phone.
     *
     * @return Returns a json object with the true/false status with msg.
     */

    public function customerAdd() {
        try {
            //check validation of user inputs
            $this->form_validation->set_rules('customer_name', $this->lang->line('customer_name'), 'trim|required');
            $this->form_validation->set_rules('customer_email', $this->lang->line('customer_email'), 'trim|required|valid_email');
            $this->form_validation->set_rules('customer_phone', $this->lang->line('customer_phone'), 'trim|required|min_length[7]');

            //if something wrong then execute this block
            if ($this->form_validation->run() == false) {
                $errors = validation_errors();
                echo json_encode(array("status" => false, "msg" => $errors));
            // every things it's ok excute this block
            } else {
                // input data array
                $data = array(
                    'customer_name' => $this->input->post('customer_name'),
                    'customer_email' => $this->input->post('customer_email'),
                    'customer_phone' => $this->input->post('customer_phone'),
                );
                //clean input for prevent cross site scripting
                $data = $this->security->xss_clean($data);
                try {
                    // insert recods
                    $insertCustomer = $this->customer->dbAddCustomer($data);
                    if ($insertCustomer > 0) {
                        echo json_encode(array("status" => true, "msg" => $this->lang->line('insert')));
                    } else {
                        echo json_encode(array("status" => true, "msg" => $this->lang->line('err_insert')));
                    }
                } catch (Exception $exc) {
                    echo json_encode(array("status" => false, "msg" => $this->lang->line('err_insert')));
                }
            }
        } catch (Exception $exc) {
            echo json_encode(array("status" => false, "msg" => $this->lang->line('unexpected')));
        }
    }

    /**
     * [AJAX] Edit Customer information.
     *
     * This method that uses to load edit information for modal window
     *
     * @param number $_GET['id'] The Customer ID.
     *
     * @return Returns a json object with the customer information.
     */

    public function ajaxEdit($id) {
        try {
            //validate customer id is number
            if (filter_var($id, FILTER_VALIDATE_INT)) {
                $data = $this->customer->dbGetById($id);
                echo json_encode($data);
            } else {
                echo json_encode(array());
            }
        } catch (Exception $exc) {
            echo json_encode(array("status" => false, "msg" => $this->lang->line('unexpected')));
        }
    }

    /**
     * [AJAX] Update Customer information.
     *
     * This method that uses to update customer information
     *
     * @param string $_POST['customer_id'] The Customer Id.
     * @param string $_POST['customer_name'] The Customer Name.
     * @param string $_POST['customer_email'] The Customer Email'.
     * @param string|number $_POST['customer_phone'] The Customer Phone.
     *
     * @return Returns a json object with the true/false status with msg.
     */
    
    public function customerUpdate() {
        try {
            //check validation of user inputs
            $this->form_validation->set_rules('customer_name', $this->lang->line('customer_name'), 'trim|required');
            $this->form_validation->set_rules('customer_email', $this->lang->line('customer_email'), 'trim|required|valid_email');
            $this->form_validation->set_rules('customer_phone', $this->lang->line('customer_phone'), 'trim|required|min_length[7]');

            //if something wrong then execute this block
            if ($this->form_validation->run() == false) {
                $errors = validation_errors();
                echo json_encode(array("status" => false, "msg" => $errors));
            // every things it's ok excute this block
            } else {
                // input data array
                $data = array(
                    'customer_name' => $this->input->post('customer_name'),
                    'customer_email' => $this->input->post('customer_email'),
                    'customer_phone' => $this->input->post('customer_phone'),
                );
                //clean input for prevent cross site scripting
                $data = $this->security->xss_clean($data);
                $customerId = $this->security->xss_clean($this->input->post('customer_id'));

                if ($customerId > 0) {
                    try {
                        // update recods
                        $updateCustomer = $this->customer->dbcuUpdateCustomer(array('customer_id' => $customerId), $data);
                        if ($updateCustomer > 0) {
                            echo json_encode(array("status" => true, "msg" => $this->lang->line('update')));
                        }else{
                            echo json_encode(array("status" => true, "msg" => $this->lang->line('err_update')));
                        }
                    } catch (Exception $exc) {
                        echo json_encode(array("status" => false, "msg" => $this->lang->line('err_update')));
                    }
                } else {
                    echo json_encode(array("status" => false, "msg" => $this->lang->line('err_update')));
                }
            }
        } catch (Exception $exc) {
            echo json_encode(array("status" => false, "msg" => $this->lang->line('unexpected')));
        }
    }

    /**
     * [AJAX] Delete Customer information.
     *
     * This method that uses to delete customer information
     *
     * @param number $_GET['id'] The Customer ID.
     * 
     * @return Returns a json object with the true/false status with msg.
     */
    
    public function customerDelete($id) {
        try {
            //validate customer id is number
            if (filter_var($id, FILTER_VALIDATE_INT)) {
                $this->customer->dbDeleteById($id);
                echo json_encode(array("status" => true,"msg" => $this->lang->line('delete')));
            } else {
                echo json_encode(array("status" => false,"msg" => $this->lang->line('err_delete')));
            }
        } catch (Exception $exc) {
            echo json_encode(array("status" => false, "msg" => $this->lang->line('unexpected')));
        }
    }

}
