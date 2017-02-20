<button class="btn btn-success" onclick="add_customer()"><i class="glyphicon glyphicon-plus"></i><?php echo $this->lang->line('add_btn'); ?></button>
<br />
<br />

<table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th><?php echo $this->lang->line('columns1'); ?></th>
            <th><?php echo $this->lang->line('columns2'); ?></th>
            <th><?php echo $this->lang->line('columns3'); ?></th>
            <th><?php echo $this->lang->line('columns4'); ?></th>
            <th><?php echo $this->lang->line('columns5'); ?>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($customers as $customer) {
        ?>
            <tr>
                <td><?php echo $customer->customer_id; ?></td>
                <td><?php echo $customer->customer_name; ?></td>
                <td><?php echo $customer->customer_email; ?></td>
                <td><?php echo $customer->customer_phone; ?></td>
                <td>
                    <button class="btn btn-primary" onclick="edit_customer(<?php echo $customer->customer_id; ?>)"><?php echo $this->lang->line('btn_edit'); ?></button>
                    <button class="btn btn-danger" onclick="delete_customer(<?php echo $customer->customer_id; ?>)"><?php echo $this->lang->line('btn_delete'); ?></button>


                </td>
            </tr>
        <?php } ?>



    </tbody>

</table>

<!-- Bootstrap modal form -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title"><?php echo $this->lang->line('modal_title') ?></h3>
            </div>
            <div class="modal-body form">
                <div id="alert-modal-body"></div>
                <?php
                $attributes = array('class' => 'form-horizontal', 'id' => 'form');
                $hidden = array('customer_id' => '-1', 'url' => base_url());
                echo form_open('#', $attributes, $hidden);
                ?>
                <div class="form-body">
                    <div class="form-group">
                        <?php
                        $attributes1 = array(
                            'class' => 'control-label col-md-3'
                        );

                        $data1 = array(
                            'name' => 'customer_name',
                            'type' => 'text',
                            'placeholder' => $this->lang->line('columns2'),
                            'class' => 'form-control',
                        );

                        echo form_label($this->lang->line('columns2'), '', $attributes1);
                        ?>  
                        <div class="col-md-9">
                            <?php echo form_input($data1); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php
                            $attributes2 = array(
                                'class' => 'control-label col-md-3'
                            );

                            $data2 = array(
                                'name' => 'customer_email',
                                'type' => 'text',
                                'placeholder' => $this->lang->line('columns3'),
                                'class' => 'form-control',
                            );

                            echo form_label($this->lang->line('columns3'), '', $attributes2);
                        ?>
                            <div class="col-md-9">
                            <?php echo form_input($data2); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php
                            $attributes3 = array(
                                'class' => 'control-label col-md-3'
                            );

                            $data3 = array(
                                'name' => 'customer_phone',
                                'type' => 'text',
                                'placeholder' => $this->lang->line('columns4'),
                                'class' => 'form-control',
                            );

                            echo form_label($this->lang->line('columns4'), '', $attributes3);
                        ?>
                            <div class="col-md-9">
                            <?php echo form_input($data3); ?>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
                        </div>
                        <div class="modal-footer">
                <?php
                            $dataBt1 = array(
                                'name' => 'button',
                                'id' => 'btnSave',
                                'class' => 'btn btn-primary',
                                'type' => 'button',
                                'content' => $this->lang->line('btn_save')
                            );

                            $dataBt2 = array(
                                'name' => 'button',
                                'data-dismiss' => 'modal',
                                'class' => 'btn btn-danger',
                                'type' => 'button',
                                'content' => $this->lang->line('err_cancel')
                            );

                            $jsBt1 = 'onClick="save()"';
                            echo form_button($dataBt1, '', $jsBt1);
                            echo form_button($dataBt2);
                ?>


                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- End Bootstrap modal form -->

            <!-- Bootstrap modal form delete -->
            <div class="modal fade" id="modal_form-delete" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title"><?php echo $this->lang->line('modal_delete_title') ?></h3>
            </div>
            <div class="modal-body form">
                <?php
                $hiddenDel = array(
                        'delete_customer_id'  => '-1',
                        'delete_url' => base_url()
                );
                echo form_hidden($hiddenDel);
                ?>
                <div id="alert-modal-body"></div>
                <div class="modal-body">
                    <p><?php echo $this->lang->line('modal_delete_message') ?></p>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" id="btnYes" class="btn btn-danger"><?php echo $this->lang->line('btn_yes') ?></a>
                <a href="#" data-dismiss="modal" aria-hidden="true" class="btn btn-primary"><?php echo $this->lang->line('btn_no') ?></a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal form -->
<!-- End Bootstrap modal delete -->