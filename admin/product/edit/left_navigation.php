<?php if (isset($_GET['pid']) AND $_GET['pid'] != '')
{
	?>

               <ul id="menu">
                    <li class="dash"><a href="<?php echo baseUrl('admin/product/edit/index.php?pid=' . $_GET['pid']); ?>" title=""><span>General</span></a></li>
                    <li class="tables"><a href="<?php echo baseUrl('admin/product/edit/category.php?pid=' . $_GET['pid']); ?>" title=""><span>Categories</span></a></li>
                    <li class="tables"><a href="<?php echo baseUrl('admin/product/edit/product_size.php?pid=' . $_GET['pid']); ?>" title=""><span>Product Size</span></a></li>
                    <li class="tables"><a href="<?php echo baseUrl('admin/product/edit/inventory.php?pid=' . $_GET['pid']); ?>" title=""><span>Inventory</span></a></li>
                    <li class="tables"><a href="<?php echo baseUrl('admin/product/edit/gallery.php?pid=' . $_GET['pid']); ?>" title=""><span>Image Gallery</span></a></li>
                    <li class="tables"><a href="<?php echo baseUrl('admin/product/edit/meta.php?pid=' . $_GET['pid']); ?>" title=""><span>Meta Information</span></a></li>
                    <li class="tables"><a href="<?php echo baseUrl('admin/product/edit/upsell.php?pid=' . $_GET['pid']); ?>" title=""><span>Product Upsell</span></a></li>
                    <li class="tables"><a href="<?php echo baseUrl('admin/product/edit/related.php?pid=' . $_GET['pid']); ?>" title=""><span>Related Product</span></a></li>
                    <li class="tables"><a href="<?php echo baseUrl('admin/product/edit/prolike.php?pid=' . $_GET['pid']); ?>" title=""><span>Product Also Like</span></a></li>
                    <li class="tables"><a href="<?php echo baseUrl('admin/product/edit/tags.php?pid=' . $_GET['pid']); ?>" title=""><span>Product Tags</span></a></li>
                    <li class="tables"><a href="<?php echo baseUrl('admin/product/edit/product_discount.php?pid=' . $_GET['pid']); ?>" title=""><span>Product Discount</span></a></li>
                    <li class="tables"><a href="<?php echo baseUrl('admin/product/edit/supplier_inventory.php?pid=' . $_GET['pid']); ?>" title=""><span>Supplier &rAarr; Inventory</span></a></li>
                    <li class="tables"><a href="javascript:redirect();" title=""><span>Back to Product List</span></a></li>

                    </li>
                </ul>
                
<?php
}
?>
