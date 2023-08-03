
<?php if(count($dropoff)>0) { ?>
<table width="100%" class="popup-table-contents" bgcolor="#dddddd">
    <th>Suburb</th>
    <th>Address</th>
    <th>Phone</th>
    <th colspan="2">Action</th>
    <?php for($k=0; $k<count($dropoff); $k++) { ?>
    <tr>
        <?php if($dropoff[$k]['suburb']!='') { ?>
        
            <td><?php echo $dropoff[$k]['suburb']; ?></td>
            <td><?php echo $dropoff[$k]['address1']; ?></td>
            <td><?php echo $dropoff[$k]['mobile']; ?></td>
            <td align="center"><a href="javascript:;" class="showdropoff" onclick="editPickup('<?php echo $dropoff[$k]['id']; ?>','<?php echo $dropoff[$k]['suburb']; ?>','<?php echo $dropoff[$k]['address1']; ?>','<?php echo $dropoff[$k]['address2']; ?>','<?php echo $dropoff[$k]['phone']; ?>','<?php echo $dropoff[$k]['mobile']; ?>','<?php echo $dropoff[$k]['passengers']; ?>','<?php echo $dropoff[$k]['comment']; ?>','<?php echo $dropoff[$k]['drop_suburb']; ?>','<?php echo $dropoff[$k]['drop_address1']; ?>','<?php echo $dropoff[$k]['drop_address2']; ?>','<?php echo $dropoff[$k]['drop_phone']; ?>','<?php echo $dropoff[$k]['drop_mobile']; ?>','<?php echo $dropoff[$k]['drop_passengers']; ?>','<?php echo $dropoff[$k]['drop_comment']; ?>','<?php echo $dropoff[$k]['direction']; ?>','<?php echo $dropoff[$k]['destination']; ?>','<?php echo $dropoff[$k]['est']; ?>','<?php echo $dropoff[$k]['drop_est']; ?>')" ><img src="<?php echo base_url();?>images/edit.png" title="edit"/></a></td>
            <td align="center"><a href="javascript:;" class="showdropoff" onclick="delPickup('<?php echo $dropoff[$k]['id']; ?>','<?php echo $dropoff[$k]['book_id']; ?>','<?php echo $dropoff[$k]['direction']; ?>','<?php echo $dropoff[$k]['type']; ?>','<?php echo $dropoff[$k]['destination']; ?>')"><img src="<?php echo base_url();?>images/delete.jpg" title="delete"/></a></td>
        
        <?php } ?>
            
        <?php if($dropoff[$k]['drop_suburb']!='') { ?>
        
            <td><?php echo $dropoff[$k]['drop_suburb']; ?></td>
            <td><?php echo $dropoff[$k]['drop_address1']; ?></td>
            <td><?php echo $dropoff[$k]['drop_mobile']; ?></td>
            <td align="center"><a href="javascript:;" class="showdropoff-arrpick" onclick="editPickup('<?php echo $dropoff[$k]['id']; ?>','<?php echo $dropoff[$k]['suburb']; ?>','<?php echo $dropoff[$k]['address1']; ?>','<?php echo $dropoff[$k]['address2']; ?>','<?php echo $dropoff[$k]['phone']; ?>','<?php echo $dropoff[$k]['mobile']; ?>','<?php echo $dropoff[$k]['passengers']; ?>','<?php echo $dropoff[$k]['comment']; ?>','<?php echo $dropoff[$k]['drop_suburb']; ?>','<?php echo $dropoff[$k]['drop_address1']; ?>','<?php echo $dropoff[$k]['drop_address2']; ?>','<?php echo $dropoff[$k]['drop_phone']; ?>','<?php echo $dropoff[$k]['drop_mobile']; ?>','<?php echo $dropoff[$k]['drop_passengers']; ?>','<?php echo $dropoff[$k]['drop_comment']; ?>','<?php echo $dropoff[$k]['direction']; ?>','<?php echo $dropoff[$k]['destination']; ?>','<?php echo $dropoff[$k]['est']; ?>','<?php echo $dropoff[$k]['drop_est']; ?>')" ><img src="<?php echo base_url();?>images/edit.png" title="edit"/></a></td>
            <td align="center"><a href="javascript:;" class="showdropoff-arrpick" onclick="delPickup('<?php echo $dropoff[$k]['id']; ?>','<?php echo $dropoff[$k]['book_id']; ?>','<?php echo $dropoff[$k]['direction']; ?>','<?php echo $dropoff[$k]['type']; ?>','<?php echo $dropoff[$k]['destination']; ?>')" ><img src="<?php echo base_url();?>images/delete.jpg" title="delete"/></a></td>
        
        <?php } ?>
            
    </tr>
    <?php } ?>
</table>

<?php } ?>