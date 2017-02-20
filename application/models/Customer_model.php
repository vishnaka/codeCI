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
 * Customer Model
 *
 * @package Model
 */
class Customer_model extends CI_Model {

    // variable that hold table name
    private $tableCustomer = 'dash_customers';

    public function __construct() {
        parent::__construct();
        //$this->load->database();
    }

    /**
     * Get All an customers records.
     *
     * This method get all customer records from database.
     *
     * @return object Returns the all records .
     */
    public function dbGetAllCustomers() {
        try {
            // get all customers
            $this->db->from($this->tableCustomer);
            $query = $this->db->get();
            return $query->result();
            // catch if error
        } catch (Exception $e) {
            log_message('error', $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            return null;
        }
    }

    /**
     * Get selected customers record.
     *
     * This method get selected customer records from database.
     *
     *@param number | $id customer_id
     *
     * @return Returns number .
     */
    public function dbGetById($id) {
        try {
            // get matching record for customer
            $this->db->from($this->tableCustomer);
            $this->db->where('customer_id', $id);
            $query = $this->db->get();
            return $query->row();
            // catch if error
        } catch (Exception $e) { 
            log_message('error', $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            return -1;
        }
    }

    /**
     * Add customers record.
     *
     * This method insert customer record to the database.
     *
     *@param array | $data Associative array with the customer
     *
     * @return Returns number .
     */
    public function dbAddCustomer($data) {
        try {
            // add customer record
            $this->db->insert($this->tableCustomer, $data);
            return $this->db->insert_id();
            // catch if error
        } catch (Exception $e) { 
            log_message('error', $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            return -1;
        }
    }

    /**
     * Update customers record.
     *
     * This method update customer record in the database.
     *
     *@param array | $data Associative array with the customer
     *@param array | $where condition of where statement
     *
     * @return Returns number .
     */
    public function dbcuUpdateCustomer($where, $data) {
        try {
            // update customer record
            $this->db->update($this->tableCustomer, $data, $where);
            return $this->db->affected_rows();
            // catch if error
        } catch (Exception $e) { 
            log_message('error', $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            return -1;
        }
    }

    /**
     * Delete customers record.
     *
     * This method delete customer record in the database.
     *
     *@param number | $id customer_id
     *
     * @return nothing .
     */
    public function dbDeleteById($id) {
        try {
            // delete customer record
            $this->db->where('customer_id', $id);
            $this->db->delete($this->tableCustomer);
        } catch (Exception $e) {
            // catch if error
            log_message('error', $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
        }
    }

}
