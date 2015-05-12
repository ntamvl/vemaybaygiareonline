<form method="get" action="/tim-ve-may-bay-gia-re/">
<div class="wapper-search-home">
  <div class="wapper-search2">
    <div class="col-md-12">
      <h2 class="title-search">Đặt vé máy bay tại đây</h2>
    </div>
    <div class="row">
      <div class="col-md-6 height-radio col-xs-6">
        <div class="radio text-chon ">
          <label>
            <input type="radio" name="trip_type" value="roundtrip" checked><span class="title-search-mini">Khứ hồi</span>
          </label>
        </div>
      </div>
      <div class="col-md-6 height-radio col-xs-6">
        <div class="radio text-chon">
          <label>
            <input type="radio" name="trip_type"  value="oneway"><span class="title-search-mini">Một chiều</span>
          </label>
        </div>
      </div>
    </div>
    <div class="row margin-top-form">
      <div class="col-md-6 min-1">
        <span class="title-search-mini">Điểm khởi hành</span>
        <div class="">
         <select id="select2-airport-code" class="form-control style-form2 populate placeholder location-choose departure-search" name="departure">
           <option value="SGN">Hồ Chí Minh  (SGN)</option>
         </select>
       </div>
     </div>
     <div class="col-md-6 min-1">
      <span class="title-search-mini">Điểm đến</span>
      <div class="">
        <select id="select2-airport-code" class="form-control style-form2 populate placeholder location-choose destination-search" name="destination">
          <option value="HAN">Hà Nội (HAN)</option>
        </select>
      </div>
    </div>
    </div>
    <div class="row margin-top-form">
      <div class="col-md-6 min-1">
        <span class="title-search-mini">Ngày đi</span>
        <div class="wap-field-form">
          <input type="text" class="form-control style-form2 from_date" name="from_date" />
        </div>
      </div>
      <div class="col-md-6 min-1">
        <span class="title-search-mini">Ngày về</span>
        <div class="wap-field-form">
          <input type="text" class="form-control style-form2 to_date" name="to_date">
        </div>
      </div>
    </div>
    <div class="col-md-4 min-2"><span class="title-search-mini">Người lớn</span><br />(>12 tuổi)
      <select class="form-control style-form" name="adult" id="adult"></select>
    </div>
    <div class="col-md-4 min-2"><span class="title-search-mini">Trẻ em</span><br />(2 - 12 tuổi)
      <select class="form-control style-form" name="children" id="child"></select>
    </div>
    <div class="col-md-4 min-2"><span class="title-search-mini">Em bé </span><br />(< 2 tuổi)
      <select class="form-control style-form" name="infant" id="infant"></select>
    </div>

    <div class="row">
      <div class="col-md-12 min-0">
        <button type="submit" id="search" name="search" class="btn btn-default btn-search btn-search-home col-md-12"><span class="glyphicon glyphicon-search"></span>
          Tìm chuyến bay
        </button>
      </div>
    </div>

  </div>

</div>
</form>
