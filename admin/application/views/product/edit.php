
<section class="main">
    <div class="container edit-product">
        <?php if(isset($updateInfo)) {echo $updateInfo; } ?>
        <div class="row">
           <div class="col-12 col-md-6">
                <div class="upload_box_new text-center col-10 offset-1">
                    <?php echo form_open_multipart('upload/do_upload', 'id="upload_form"');?>
                        <div class="file-input-wrapper">
                            <input name="userfile" id="userfile" type="file" class="file_input" />
                            <input type="button" class="btn" value="Upload image">
                        </div>
                        <div id="uploading">
                            <img src="<?php echo $product['image'] ?>" class="temp_image" alt="">
                        </div>
                        <div class="main progress mt-3" style="display:none;">
                            <div class="main progress-bar bg-success"></div>
                        </div>
                        <div id="targetLayer"></div><br/>
                    </form>
                </div>
                <div class="upload_box_new text-center col-10 offset-1">
                    <?php echo form_open_multipart('upload/do_upload', 'id="upload_gallery_form"');?>
                        <div class="file-input-wrapper">
                            <input name="userfile" id="usergallery" type="file" class="file_input" />
                            <button type="button" class="btn"><i class="fa fa-plus"></i> Image</button>
                        </div>
                        <div class="gal progress mt-1" style="display:none;">
                            <div class="gal progress-bar bg-success"></div>
                        </div>
                        <div class="gallerycontainer mt-1 row">
                            <?php
                                $src = explode(',', $product['gallery']);
                                foreach($src as $src)
                                {
                                    if(!empty($src))
                                    {
                                        echo '<div class=" gallery-wrapper col-12 col-sm-6 mb-1 col-md-6"><img class="img-thumbnail" src="'.$src.'" ><i style="cursor:pointer" src="'.$src.'" class="fa remove-gallery text-danger fa-trash"></i></div>';
                                    }
                                }
                            ?>
                        </div>
                        <div id="gallery_info"></div><br/>
                    </form>
                </div>
            </div>
           <div class="col-12 col-md-6">
                <?php echo form_open('product/edit/'.$product['id'], 'id="product_edit_form"');?>
                    <div class="form">
                        <label>Name</label>
                        <div class="text-danger form-error"><?php echo form_error('name');?></div>
                        <input type="text" id="name" required name="name" placeholder="Name of product" value="<?php echo $product['name'] ?>" >
                    </div>
                    <div class="form">
                        <input type="text" id="image-name" value="<?php echo $product['image'] ?>" name="image" hidden>
                    </div>
                    <div class="form">
                        <input type="text" id="gallery-photos" value="<?php echo $product['gallery'] ?>" name="gallery" hidden>
                    </div>
                    <div class="form">
                        <label>Category</label>
                        <select name="category" class="category" >
                            <option value="uncategorized">None</option>
                            <?php
                            if($categories != false)
                            {
                        
                                foreach($categories as $category)
                                { ?>
                                    
                                    <option value="<?php echo $category['name'] ?>"

                                    <?php
                                    
                                    if($product['category'] == $category['name'])
                                    {
                                        echo "selected = yes";
                                    }

                                    ?>
                                     ><?php echo $category['name'] ?></option>

                                <?php }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mt-4 form bg-light mb-4 p-2" >
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" 
                            <?php
                            if($product['featured'] == 'yes')
                            {
                                echo 'checked';
                            }
                            ?>
                            id="featured" value="yes" name="featured">
                            <label class="custom-control-label" for="featured">Set Featured</label>
                        </div> 
                    </div>
                    <div class="form">
                        <label>Description</label>
                        <div class="text-danger form-error"><?php echo form_error('description');?></div>
                        <textarea required name="description" id="description" cols="30" rows="5  " placeholder="product description"><?php echo $product['description'] ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4">
                            <label>Price</label>
                            <div class="text-danger form-error"><?php echo form_error('price');?></div>
                            <input type="text" value="<?php echo $product['price'] ?>" name="price" placeholder="Price (₦)">
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <label>Weight</label>
                            <div class="text-danger form-error"><?php echo form_error('weight');?></div>
                            <input type="text" name="weight" value="<?php echo $product['weight'] ?>" placeholder="Weight (kg)">
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <label>Dimention</label>
                            <div class="text-danger form-error"><?php echo form_error('dimention');?></div>
                            <input type="text" value="<?php echo $product['dimention'] ?>" name="dimention" placeholder="Dimention (m)">
                        </div>
                    </div>
                    <button type="submit" name="submit" class=" mt-3 submit ml-4 btn btn-secondary btn-sm">Update</button>
                </form>
                <div id="add_info" class="mt-2" style="font-size:0.8em;"></div>
            </div>
        </div>
    </div>
</section>