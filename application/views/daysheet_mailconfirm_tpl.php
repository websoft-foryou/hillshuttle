<form name="mailform" id="mailform">
<table width="100%" cellspacing="2" cellpadding="5" class="popup-table-contents" bgcolor="#f2f2f2">
    <tr>
        <th align="left"><input type="checkbox" name="chkall" id="chkall" onclick="chkSelectall()"/>Select All</th>
        <th align="left">Booking Number</th>
    </tr>
<?php
$total = count($bookids);
asort($bookids);
foreach ($bookids as $row) {
    
    ?>
    <tr>
        <td><input type="checkbox" name="bookids" id="bookids" class="bookid_list" value="<?php echo $row; ?>" /></td>
        <td>
            <?php 
                echo $row;
            ?>
        </td>
    </tr>
<?php
}
?>
    <tr>
        <td colspan="2" align="center">
            <input type="button" name="conmailsend" id="conmailsend" value="Send" class="bgbtn" onclick="mailConfirm()" />
            <input type="button" name="cancelmailbtn" id="cancelmailbtn" value="Cancel" class="bgbtn" onclick="popupClose()" />
        </td>
    </tr>
</table>
</form>