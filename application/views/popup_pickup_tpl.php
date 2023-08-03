
<?php if(count($pickup)>0) { ?>
<table width="100%" class="popup-table-contents" bgcolor="#f2f2f2">
    <!-- <th>Client</th> -->
    <th>Suburb</th>
    <th>Address</th>
    <th>Phone</th>
    <th>Action</th>
    <?php for($k=0; $k<count($pickup); $k++) { ?>
    <tr>
        <?php if($pickup[$k]['suburb']!='') { ?>
        
            <td><?php echo $pickup[$k]['suburb']; ?></td>
            <td><?php echo $pickup[$k]['address1']; ?></td>
            <td><?php echo $pickup[$k]['mobile']; ?></td>
            <td align="center"><a href="javascript:;" class="showpickup" onclick="editPickup('<?php echo $pickup[$k]['id']; ?>','<?php echo $pickup[$k]['suburb']; ?>','<?php echo $pickup[$k]['address1']; ?>','<?php echo $pickup[$k]['address2']; ?>','<?php echo $pickup[$k]['phone']; ?>','<?php echo $pickup[$k]['mobile']; ?>','<?php echo $pickup[$k]['passengers']; ?>','<?php echo $pickup[$k]['comment']; ?>','<?php echo $pickup[$k]['drop_suburb']; ?>','<?php echo $pickup[$k]['drop_address1']; ?>','<?php echo $pickup[$k]['drop_address2']; ?>','<?php echo $pickup[$k]['drop_phone']; ?>','<?php echo $pickup[$k]['drop_mobile']; ?>','<?php echo $pickup[$k]['drop_passengers']; ?>','<?php echo $pickup[$k]['drop_comment']; ?>','<?php echo $pickup[$k]['direction']; ?>','<?php echo $pickup[$k]['destination']; ?>','<?php echo $pickup[$k]['est']; ?>','<?php echo $pickup[$k]['drop_est']; ?>')" ><img src="<?php echo base_url();?>images/edit.png" title="edit"/></a></td>
            <td align="center"><a href="javascript:;" class="showpickup" onclick="delPickup('<?php echo $pickup[$k]['id']; ?>','<?php echo $pickup[$k]['book_id']; ?>','<?php echo $pickup[$k]['direction']; ?>','<?php echo $pickup[$k]['type']; ?>','<?php echo $pickup[$k]['destination']; ?>')" ><img src="<?php echo base_url();?>images/delete.jpg" title="delete"/></a></td>
        
       <?php } ?>
            
        <?php if($pickup[$k]['drop_suburb']!='') { ?>
        
            <td><?php echo $pickup[$k]['drop_suburb']; ?></td>
            <td><?php echo $pickup[$k]['drop_address1']; ?></td>
            <td><?php echo $pickup[$k]['drop_mobile']; ?></td>
            <td align="center"><a href="javascript:;" class="showpickup-depdrop" onclick="editPickup('<?php echo $pickup[$k]['id']; ?>','<?php echo $pickup[$k]['suburb']; ?>','<?php echo $pickup[$k]['address1']; ?>','<?php echo $pickup[$k]['address2']; ?>','<?php echo $pickup[$k]['phone']; ?>','<?php echo $pickup[$k]['mobile']; ?>','<?php echo $pickup[$k]['passengers']; ?>','<?php echo $pickup[$k]['comment']; ?>','<?php echo $pickup[$k]['drop_suburb']; ?>','<?php echo $pickup[$k]['drop_address1']; ?>','<?php echo $pickup[$k]['drop_address2']; ?>','<?php echo $pickup[$k]['drop_phone']; ?>','<?php echo $pickup[$k]['drop_mobile']; ?>','<?php echo $pickup[$k]['drop_passengers']; ?>','<?php echo $pickup[$k]['drop_comment']; ?>','<?php echo $pickup[$k]['direction']; ?>','<?php echo $pickup[$k]['destination']; ?>','<?php echo $pickup[$k]['est']; ?>','<?php echo $pickup[$k]['drop_est']; ?>')" ><img src="<?php echo base_url();?>images/edit.png" title="edit"/></a></td>
            <td align="center"><a href="javascript:;" class="showpickup-depdrop" onclick="delPickup('<?php echo $pickup[$k]['id']; ?>','<?php echo $pickup[$k]['book_id']; ?>','<?php echo $pickup[$k]['direction']; ?>','<?php echo $pickup[$k]['type']; ?>','<?php echo $pickup[$k]['destination']; ?>')" title="delete"><img src="<?php echo base_url();?>images/delete.jpg" title="delete"/></a></td>
        
       <?php } ?>
            
    </tr>
    <?php } ?>
</table>

<?php } ?>
