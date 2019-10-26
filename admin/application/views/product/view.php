
<section class="main">
    <div class="container users">
        <div class="row">
            <div class="col-12 filter">
                <div class="text-left">
                    <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#productModal"><i class="fa fa-plus"></i></button>
                </div>
                <div class="text-right">
                    <?php echo form_open('product/view');?>
                        <input type="search" name="search" placeholder="search product" >
                        <button type="submit" class="btn btn-sm btn-link"><i class="ml-2 text-warning fa fa-search"></i></button>
                    </form>
                </div>
                <div class="text-primary mt-4 mb-3">Sort</div>
                <div class="sort-button">
                    <?php echo form_open('admin/product/view');?>
                        <input type="text" name="name" value="name" hidden>
                        <button type="submit" class="mr-5 "><i class="fa fa-user mr-3 mb-3"></i>by product name</button>
                    </form>
                    <?php echo form_open('admin/product/view');?>
                        <input type="text" name="date" value="date_added" hidden>
                        <button type="submit" ><i class="fa fa-clock mr-3"></i>by date</button> 
                    </form>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <div class="table-responsive table-wrapper">
                    <table class="table data-table products-table">
                    <?php 
                    if($products != false)
                    {
                        foreach($products as $product)
                        { ?>
                        <tr class="product-row">
                            
                            <td>
                                <div class="title">Product Image</div>
                                <img class="" src="<?php echo $product['image']?>" alt="image">
                            </td>
                            <td>
                                <div class="title">Product name</div>
                                <div class="data"><?php echo $product['name']?></div>
                            </td>
                            <td>
                                <div class="title">Category</div>
                                <div class="data"><?php echo $product['category']?></div>
                            </td>
                            <td>
                                <div class="title">Price (₦)</div>
                                <div class="data"><?php echo $product['price']?></div>
                            </td>
                            <td>
                                <div class="title">Date Added</div>
                                <div class="data"><?php echo date('M d, Y',strtotime($product['date_added']))?></div>
                            </td>
                            <td>
                                <div class="title text-center">Action</div>
                                <div class="d-flex justify-content-between">
                                    <div class="action-button edit">
                                        <a href="<?php echo base_url.'/index.php/product/edit/'.$product['id'] ?>" id="<?php echo $product['id']?>" class=" edit data mr-3"><i class=" text-primary fa fa-edit"></i></a>
                                    </div>
                                    <div class="action-button">
                                        <a href="javascript:void(0)" class="data delProduct"  id="<?php echo $product['id']?>"><i class=" text-danger fa fa-trash"></i></a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php 
                        }
                    }
                    else
                    {
                        echo "No Products Found!";
                    }
                    ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add Modal -->
<div class="modal" id="productModal">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title title">Add Product</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
       <div class="container">
           <div class="row">
               <div class="col-12 col-md-6">
                    <div class="upload_box_new text-center col-10 offset-1">
                        <?php echo validation_errors(); ?>
                        <?php echo form_open_multipart('upload/do_upload', 'id="upload_form"');?>
                            <div class="file-input-wrapper">
                                <input name="userfile" id="userfile" type="file" class="file_input" />
                                <input type="button" class="btn" value="Upload image">
                            </div>
                            <div id="uploading">
                                <img src="" class="temp_image" alt="">
                            </div>
                            <div class="main progress mt-3" style="display:none;">
                                <div class="main progress-bar bg-success"></div>
                            </div>
                            <div id="targetLayer"></div><br/>
                        </form>
                    </div>
                    <div class="upload_box_new text-center col-10 offset-1">
                        <?php echo validation_errors(); ?>
                        <?php echo form_open_multipart('admin/upload/do_upload', 'id="upload_gallery_form"');?>
                            <div class="file-input-wrapper">
                                <input name="userfile" id="usergallery" type="file" class="file_input" />
                                <button type="button" class="btn"><i class="fa fa-plus"></i> Image</button>
                            </div>
                            <div class="gal progress mt-1" style="display:none;">
                                <div class="gal progress-bar bg-success"></div>
                            </div>
                            <div class="gallerycontainer mt-1 row"></div>
                            <div id="gallery_info"></div><br/>
                        </form>
                    </div>
               </div>
               <div class="col-12 col-md-6">
                    <?php echo form_open('product/create', 'id="product_form"');?>
                        <div class="form">
                            <input type="text" id="name" required name="name" placeholder="Name of product" >
                        </div>
                        <div class="form">
                            <input type="text" id="image-name" name="image" hidden>
                        </div>
                        <div class="form">
                            <input type="text" id="gallery-photos" name="gallery" hidden>
                        </div>
                        <div class="form">
                            <select name="category" class="category" >
                                <option value="uncategorized">None</option>
                                <?php
                                if($categories != false)
                                {
                                    foreach($categories as $category)
                                    {
                                        echo "<option value='{$category['name']}'>{$category['name']}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mt-4 form bg-light p-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="featured" value="yes" name="featured">
                                <label class="custom-control-label" for="featured">Set Featured</label>
                            </div> 
                        </div>
                        <div class="form">
                            <textarea required name="description" id="description" cols="30" rows="5  " placeholder="product description"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-4">
                                <input type="text" name="price" placeholder="Price (₦)">
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <input type="text" name="weight" placeholder="Weight (kg)">
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <input type="text" name="dimention" placeholder="Dimention (m)">
                            </div>
                        </div>
                        <button type="submit" class=" mt-3 submit ml-4 btn btn-secondary btn-sm">Add</button>
                    </form>
                    <div id="add_info" class="mt-2" style="font-size:0.8em;"></div>
               </div>
           </div>
       </div>
      </div>

    </div>
  </div>
</div>
