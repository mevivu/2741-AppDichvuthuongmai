<div class="col-12 col-md-9">
<div class="row">
        <!-- name -->
        <h2 style="text-align: center; color: red;">Cấp quyền ưu tiên</h2>
        <div class="col-12">
           <div class="card">
               <div class="card-header">
                    Thông tin & giá tiền
               </div>
               <input name="store_id" value="{{auth('store')->user()->id}}" type="hidden"/>
               <div class="card-body row">
                   <!-- name -->
                   <div class="col-6">
                        <div class="mb-3">
                            <label class="control-label">Số ngày đăng kí ưu tiên</label>
                            <x-input name="day" :value="$day" :required="true" readonly />
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="control-label">Tổng tiền</label>
                            <x-input-price name="total" :value="$kq" :required="true" readonly />
                        </div>
                    </div> 
               </div>
           </div>
       </div>   
       <div class="col-12">
           <div class="card">
               <div class="card-header">
                    Thông tin Admin & Thanh toán
               </div>
               <div class="card-body row">
                   <!-- name -->
                   <div class="col-6">
                        <div class="mb-3">
                            <label class="control-label">Tên ngân hàng: <strong>{{$info->bankname}}</strong></label>
                        
                        </div>
                    </div>
                   <div class="col-6">
                        <div class="mb-3">
                            <label class="control-label">Số tài khoản: <strong>{{$info->accountnumber}}</strong></label>
                        
                        </div>
                    </div>
                    <div class="col-12">
                    <div class="card-body p-2">
                    <label class="control-label">Mã QR:</label>
                        <x-input-image-ckfinder name="qr" showImage="qr" :value="$info->qr"/>
                    </div>
                    </div> 
                    <div class="col-6">
                        <div class="mb-3">
                        <div class="card-body p-2">
                        <div class="d-flex align-items-center h-100 gap-2">
                                <x-button.submit :title="__('Đã chuyển chờ duyệt')" name="submitter" value="save" />
                                <x-button.submit :title="__('Huỷ bỏ')" name="submitter" value="delete" style="background-color: red;" />
                            </div>
                            
                        </div>
                        
                        </div>
                    </div>
               </div>
           </div>
       </div> 
    </div>
</div>

