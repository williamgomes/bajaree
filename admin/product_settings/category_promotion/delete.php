<?php
include ('../../../config/config.php');

$pid = $_GET['pid'];
//getting image path and unlinking
$unlinkimg = mysqli_query($con,"SELECT * FROM category_promotion WHERE CP_id='$pid'");
$unlinkrow = mysqli_fetch_assoc($unlinkimg);
$imgname = $unlinkrow['CP_image_name'];
unlink ('../../../upload/category_banner/' . $imgname);//deleting original image

//deleting image details from db
$delimg = mysqli_query($con,"DELETE FROM category_promotion WHERE CP_id='$pid'");


//getting images from db


if($delimg)
{
	echo '<font color="green"><b>Image deleted successfully.</b></font>';
	echo '<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                <thead>
                                    <tr>
                                        <th>Promotion ID</th>
                                        <th>Promotion Title</th>
                                        <th>Promotion Category</th>
                                        <th>Promotion Image</th>
                                        <th>Promotion Last Updated</th>
                                        <th>Promotion Updated By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>';
	$catbansql = mysqli_query($con, "SELECT * FROM category_promotion");
	while ($catbanrow = mysqli_fetch_array($catbansql)) 
	{
	                                        echo '<tr class="gradeA">
                                            <td>'.$catbanrow['CP_id'].'</td>
                                            <td>'.$catbanrow['CP_title'].'</td>
                                            <td>'.$catbanrow['CP_category_id'].'</td>
                                            <td align="center"><img src="'.baseUrl('upload/category_banner/').$catbanrow['CP_image_name'].'" width="40px" style="margin:0 auto !important;" /></td>
                                            <td>'.$catbanrow['CP_updated'].'</td>
                                            <td>';
											$aid = $catbanrow['CP_updated_by'];
											$adminsql = mysqli_query($con, "SELECT (admin_full_name) FROM admins WHERE admin_id='$aid'");
											$adminrow = mysqli_fetch_array($adminsql);
											echo $adminrow[0];
											echo '</td>
                                            <td><a href="edit.php?pid='.base64_encode($catbanrow['CP_id']).'" title="Edit"><img src="../images/edit.png" height="12px" width="12px" /></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:delid('.$catbanrow['CP_id'].');" title="Delete"><img src="../images/delete.png" height="12px" width="12px" /></a></td>
                                        </tr>';
	}
                                 echo '</tbody>
                            </table>';
	
}
else
{
	echo '<font color="red"><b>Image could not be deleted.</b></font>';
	echo '<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                <thead>
                                    <tr>
                                        <th>Promotion ID</th>
                                        <th>Promotion Title</th>
                                        <th>Promotion Category</th>
                                        <th>Promotion Image</th>
                                        <th>Promotion Last Updated</th>
                                        <th>Promotion Updated By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>';
	$catbansql = mysqli_query($con, "SELECT * FROM category_promotion");
	while ($catbanrow = mysqli_fetch_array($catbansql)) 
	{
	                                        echo '<tr class="gradeA">
                                            <td>'.$catbanrow['CP_id'].'</td>
                                            <td>'.$catbanrow['CP_title'].'</td>
                                            <td>'.$catbanrow['CP_category_id'].'</td>
                                            <td align="center"><img src="'.baseUrl('upload/category_banner/').$catbanrow['CP_image_name'].'" width="40px" style="margin:0 auto !important;" /></td>
                                            <td>'.$catbanrow['CP_updated'].'</td>
                                            <td>';
											$aid = $catbanrow['CP_updated_by'];
											$adminsql = mysqli_query($con, "SELECT (admin_full_name) FROM admins WHERE admin_id='$aid'");
											$adminrow = mysqli_fetch_array($adminsql);
											echo $adminrow[0];
											echo '</td>
                                            <td><a href="edit.php?pid='.base64_encode($catbanrow['CP_id']).'" title="Edit"><img src="../images/edit.png" height="12px" width="12px" /></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:delid('.$catbanrow['CP_id'].');" title="Delete"><img src="../images/delete.png" height="12px" width="12px" /></a></td>
                                        </tr>';
	}
                                 echo '</tbody>
                            </table>';
}
?>