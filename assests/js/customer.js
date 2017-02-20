/* ----------------------------------------------------------------------------
 * Simple Data Grid System - by Amila
 *
 * @package     Simple Data Grid System
 * @author      Amila Tilakarathna<vishnaka23@gmail.com>
 * @copyright   Copyright (c) 2017, Amila
 * @link        http://localhost/codeCI/
 * @since       v1.0.0
 * ---------------------------------------------------------------------------- */

$(document).ready( function () {
    $('#table_id').DataTable();
} );
var save_method; //for save method string
var baseurl = '';


function add_customer()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('#modal_form').modal('show'); // show bootstrap modal
     
}

function edit_customer(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('#alert-modal-body').removeClass('alert alert-danger');
    $('#alert-modal-body').html('');
    
    baseurl = $('[name="url"]').attr('value');
      
    //Ajax Load data from ajax
    $.ajax({
        url : baseurl+'index.php/customer/ajaxEdit/' + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="customer_id"]').val(data.customer_id);
            $('[name="customer_name"]').val(data.customer_name);
            $('[name="customer_email"]').val(data.customer_email);
            $('[name="customer_phone"]').val(data.customer_phone);
            


            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Customer Form'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}



function save()
{
    var url;
    baseurl = $('[name="url"]').attr('value');
    if(save_method == 'add')
    {          
        url = baseurl+'index.php/customer/customerAdd';
    }
    else
    {    
        url = baseurl+'index.php/customer/customerUpdate';
    }

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            //if success close modal and reload ajax table
            if(data.status){
                $('#modal_form').modal('hide');
                location.reload();// for reload a page
            }else{
                $('#alert-modal-body').addClass('alert alert-danger');
                $('#alert-modal-body').html(data.msg);
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });
}


function delete_customer(id)
{
    $('[name="delete_customer_id"]').val(id);
    $('#modal_form-delete').modal('show');

}

$('#btnYes').click(function() {
    // handle deletion here
    
  	baseurl = $('[name="delete_url"]').attr('value');
        id=$('[name="delete_customer_id"]').attr('value');

        // ajax delete data from database
        $.ajax({
            url : baseurl+'index.php/customer/customerDelete/'+id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
               location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

});