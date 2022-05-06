<div class="form-group  my-1 ">
     <strong>Features</strong>
    <div class="sufrati-backend-input-seperator">
         <strong>Select Features</strong>
    </div>
</div>
<div class="form-check  my-1">
  
         <input type="checkbox" checked="checked"   name="editfeatures[]"  value="1" />
         <label class="form-check-label" for=""> Profile Page</label>
</div>
<div class="form-check  my-1">
   
         <input type="checkbox" checked="checked" name="editfeatures[]"  value="2" /> 
         <label class="form-check-label" for=""> Branch Management</label>

</div>
<div class="form-check  my-1">
   
         <input type="checkbox" <?php if(isset($permissions) and in_array(3,$permissions)) echo "checked";?>   name="editfeatures[]"  value="3" />
         <label class="form-check-label" for="member_date"> Sample Menu</label>

</div>
<div class="form-check  my-1">
   
         <input type="checkbox" <?php if(isset($permissions) and in_array(4,$permissions)) echo "checked";?>   name="editfeatures[]"  value="4" />
         <label class="form-check-label" for=""> Full Menu + PDF</label>

</div>
<div class="form-check  my-1">
   
         <input type="checkbox" <?php if(isset($permissions) and in_array(6,$permissions)) echo "checked";?>   name="editfeatures[]"  value="6" />
         <label class="form-check-label" for=""> Photo Gallery (3 Photos)</label>

</div>
<div class="form-check  my-1">
   
         <input type="checkbox" <?php if(isset($permissions) and in_array(7,$permissions)) echo "checked";?>   name="editfeatures[]"  value="7" />
         <label class="form-check-label" for=""> Photo Gallery (6 Photos)</label>
</div>
<div class="form-check  my-1">
   
         <input type="checkbox" <?php if(isset($permissions) and in_array(8,$permissions)) echo "checked";?>   name="editfeatures[]"  value="8" />
         <label class="form-check-label" for=""> Photo Gallery (12 Photos)</label>

</div>
<div class="form-check  my-1">
   
         <input type="checkbox" <?php if(isset($permissions) and in_array(9,$permissions)) echo "checked";?>   name="editfeatures[]"  value="9" />
         <label class="form-check-label" for=""> Photo Gallery (20 Photos)</label>

</div>
<div class="form-check  my-1">
   
         <input type="checkbox" <?php if(isset($permissions) and in_array(16,$permissions)) echo "checked";?>   name="editfeatures[]"  value="16" />
         <label class="form-check-label" for=""> News Feed</label>

</div>
<div class="form-check  my-1">
   
         <input type="checkbox" <?php if(isset($permissions) and in_array(10,$permissions)) echo "checked";?>   name="editfeatures[]"  value="10" />
         <label class="form-check-label" for=""> Special Offer (1 Offer)</label>

</div>
<div class="form-check  my-1">
   
         <input type="checkbox" <?php if(isset($permissions) and in_array(11,$permissions)) echo "checked";?>   name="editfeatures[]"  value="11" />
         <label class="form-check-label" for=""> Special Offer (3 Offers)</label>

</div>
<div class="form-check  my-1">
   
         <input type="checkbox" <?php if(isset($permissions) and in_array(17,$permissions)) echo "checked";?>   name="editfeatures[]"  value="17" />
         <label class="form-check-label" for=""> Fan Club</label>

</div>
<div class="form-check  my-1">
   
         <input  type="checkbox" <?php if(isset($permissions) and in_array(14,$permissions)) echo "checked";?>   name="editfeatures[]"  value="14" />
         <label class="form-check-label" for=""> Comments Response</label>

</div>
<div class="form-check  my-1">
   
         <input  type="checkbox" <?php if(isset($permissions) and in_array(15,$permissions)) echo "checked";?>   name="editfeatures[]"  value="15" />
         <label class="form-check-label" for=""> Video Gallery</label>

</div>
<div class="form-check  my-1">
   
         <input  type="checkbox" <?=(isset($permissions) and in_array(13,$permissions)) ? "checked" :""?>   name="editfeatures[]"  value="13" />
         <label class="form-check-label" > Polls</label>

</div>
<div class="form-check  my-1">
   
         <input  type="checkbox" <?php if(isset($permissions) and in_array(12,$permissions)) echo "checked";?>   name="editfeatures[]"  value="12" />
         <label class="form-check-label" for=""> Booking</label>

</div>
