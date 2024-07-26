<div class="col-12 col-md-9">
<div class="row">
        <!-- name -->
        <h2 style="text-align: center; color: red;">Yêu cầu cấp quyền ưu tiên </h2>
        <div class="col-12">
           <div class="card">
               <div class="card-header">
                   Thông tin & giá tiền
               </div>
               <div class="card-body row">
                   <!-- name -->
                   <div class="col-6">
                        <div class="mb-3">
                            <label class="control-label">Nhập số ngày đăng kí ưu tiên</label>
                            <x-input name="day"  type="number" :value="old('day')" :required="true" :placeholder="__('Ngày')" />
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                        <div class="card-body p-2">
                        <div class="d-flex align-items-center h-100 gap-2" style="margin-top:10px">
                                <x-button.submit :title="__('Báo giá')" name="submitter" value="save" />
                            </div>
                        </div>
                        </div>
                    </div>    
                    
                   <!--Sku-->
                   
                    <!-- price_selling -->
               </div>
           </div>
       </div>    
    </div>
</div>
