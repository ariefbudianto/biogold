@extends('theme01.member.layout')
@section('content')
   @if(Session::get('errors'))
    <div class="alert alert-danger alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
     @foreach($errors->all('<li>:message</li>') as $message)
       {!! $message !!}
     @endforeach
    </div>
  @endif
  <form class="form-horizontal" method="POST" action="{{ route('user.update') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="row">
      <div class="col-lg-6">
        <div class="well bs-component">
            <fieldset>
              <legend>LINK PROMOSI</legend>
              <div class="form-group">
                <label for="inputRekNo" class="col-lg-12">{{ url('/').'/?ref='.$user->username }}</label>
              </div>

              <legend>PROFILE</legend>
              <div class="form-group">
                <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                <div class="col-lg-10">
                  <input type="text" class="form-control" id="inputEmail" value="{{ $user->email }}" readonly="true" />
                </div>
              </div>
              
              <div class="form-group">
                <label for="inputName" class="col-lg-2 control-label">Nama </label>
                <div class="col-lg-10">
                  <input type="text" name="first_name" class="form-control" id="inputName" placeholder="Nama lengkap sesuai KTP" value="{{ $user->first_name }}" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-lg-2 control-label">Gender</label>
                <div class="col-lg-10">
                  <div class="radio">
                    <label>
                      <input type="radio" name="gender" id="optionsRadios1" value="M" {{ $checkM }} />
                      Pria
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="gender" id="optionsRadios2" value="F" {{ $checkF }} />
                      Wanita
                    </label>
                  </div>
                </div>
              </div>
              
              <div class="form-group">
                <label for="inputHandphone" class="col-lg-2 control-label">Handphone </label>
                <div class="col-lg-10">
                  <input type="text" name="handphone" class="form-control" id="inputHandphone" placeholder="Nomor handphone" value="{{ old('handphone',$user->handphone) }}" />
                </div>
              </div>

              <div class="form-group">
                <label for="inputAddress1" class="col-lg-2 control-label">Alamat </label>
                <div class="col-lg-10">
                  <input type="text" name="address1" class="form-control" id="inputAddress1" placeholder="Alamat" value="{{ old('address1',$user->address1) }}" />
                </div>
              </div>

              <div class="form-group">
                <label for="inputAddress2" class="col-lg-2 control-label">&nbsp; </label>                    
                <div class="col-lg-10">
                  <input type="text" name="address2" class="form-control" id="inputAddress2" placeholder="Lanjutan alamat (opsional)" value="{{ old('address2',$user->address2) }}" />
                </div>
              </div>
              
              <div class="form-group">
                <label for="inputCity" class="col-lg-2 control-label">Kota </label>
                <div class="col-lg-10">
                  <input type="text" name="city" class="form-control" id="inputCity" placeholder="Kota" value="{{ old('city',$user->city) }}" />
                </div>
              </div>
              
              <div class="form-group">
                <label for="inputProvince" class="col-lg-2 control-label">Propinsi </label>
                <div class="col-lg-10">
                  <input type="text" name="province" class="form-control" id="inputProvince" placeholder="Propinsi" value="{{ old('province',$user->province) }}" />
                </div>
              </div>
              
              <div class="form-group">
                <label for="inputCountry" class="col-lg-2 control-label">Negara </label>
                <div class="col-lg-10">
                  <input type="text" name="country" class="form-control" id="inputCountry" placeholder="Negara" value="{{ old('country',$user->country) }}" />
                </div>
              </div>


              <legend>REKENING BANK</legend>
              <div class="form-group">
                <label for="inputRekNo" class="col-lg-2 control-label">Nomor Rekening</label>
                <div class="col-lg-10">
                  <input type="text" name="rekNo" class="form-control" id="inputRekNo" placeholder="Nomor Rekening" value="{{ old('rekNo',$user->rekNo) }}" />
                </div>
              </div>

              <div class="form-group">
                <label for="inputRekNama" class="col-lg-2 control-label">Atas Nama</label>
                <div class="col-lg-10">
                  <input type="text" name="rekNama" class="form-control" id="inputRekNama" placeholder="Rekening atas nama" value="{{ old('rekNama',$user->rekNama) }}" />
                </div>
              </div>

              <div class="form-group">
                <label for="inputRekBank" class="col-lg-2 control-label">Bank</label>
                <div class="col-lg-10">
                  <input type="text" name="rekBank" class="form-control" id="inputRekBank" placeholder="Bank" value="{{ old('rekBank',$user->rekBank) }}" />
                </div>
              </div>
              
              <div class="form-group">
                <label for="inputRekCabang" class="col-lg-2 control-label">Cabang </label>
                <div class="col-lg-10">
                  <input type="text" name="rekCabang" class="form-control" id="inputRekCabang" placeholder="Cabang" value="{{ old('rekCabang',$user->rekCabang) }}" />
                </div>
              </div>
              
              <div class="form-group">
                <label for="inputRekKota" class="col-lg-2 control-label">Kota </label>
                <div class="col-lg-10">
                  <input type="text" name="rekKota" class="form-control" id="inputRekKota" placeholder="Kota asal bank" value="{{ old('rekKota',$user->rekKota) }}" />
                </div>
              </div>

            </fieldset>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="well bs-component">
            <fieldset>

              <legend>CONTACT BOX</legend>
              <div class="form-group">
                <div class="col-lg-12">
                  <textarea name="contactbox" class="form-control" rows="3" id="contactbox" placeholder="Bila dikosongkan akan diisi default (nama, email dan nomor handphone Anda).">{{ old('contactbox',$user->contactbox) }}</textarea>
                  <span class="help-block">Isi <em>contact box</em> ini akan muncul otomatis pada halaman website promosi sesuai parameter referral yang diberikan.</span>
                </div>
              </div>

              <legend>REGISTRATION</legend>
              <div class="form-group">
                <label for="tglkonfirmasi" class="col-lg-2 control-label">Tgl Konfirmasi</label>
                <div class="col-lg-10">
                  <input type="text" class="form-control" id="tglkonfirmasi" value="{{ $tglkonfirmasi }}" readonly="true" />
                </div>
              </div>

              <div class="form-group">
                <label for="tgltransfer" class="col-lg-2 control-label">Tgl Transfer</label>
                <div class="col-lg-10">
                  <input type="text" class="form-control" id="tgltransfer" value="{{ $tgltransfer }}" readonly="true" />
                </div>
              </div>

              <div class="form-group">
                <label for="jmltransfer" class="col-lg-2 control-label">Jumlah Transfer</label>
                <div class="col-lg-10">
                  <input type="text" class="form-control" id="jmltransfer" value="{{ $jmltransfer }}" readonly="true" />
                </div>
              </div>

              <div class="form-group">
                <label for="tgllunas" class="col-lg-2 control-label">Tgl Lunas</label>
                <div class="col-lg-10">
                  <input type="text" class="form-control" id="tgllunas" value="{{ $tgllunas }}" readonly="true" />
                </div>
              </div>
              
              <legend>LAIN-LAIN</legend>
              <div class="form-group">
                <label for="inputJoinDate" class="col-lg-2 control-label">Tgl Join </label>
                <div class="col-lg-10">
                  <input type="text" class="form-control" id="inputJoinDate" value="{{ $user->created_at }}" readonly="true" />
                </div>
              </div>
              
              <div class="form-group">
                <label for="inputUpline" class="col-lg-2 control-label">Upline </label>
                <div class="col-lg-10">
                  <input type="text" class="form-control" id="inputUpline" value="{{ $user->username_upline }}" readonly="true" />
                </div>
              </div>

                    <!-- <div class="form-group">
                      <label for="select" class="col-lg-2 control-label">Selects</label>
                      <div class="col-lg-10">
                        <select class="form-control" id="select">
                          <option>1</option>
                          <option>2</option>
                          <option>3</option>
                          <option>4</option>
                          <option>5</option>
                        </select>
                        <br>
                        <select multiple="" class="form-control">
                          <option>1</option>
                          <option>2</option>
                          <option>3</option>
                          <option>4</option>
                          <option>5</option>
                        </select>
                      </div>
                    </div> -->
            </fieldset>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="form-group">
        <div class="col-lg-10 col-lg-offset-2">
          <button type="submit" class="btn btn-primary">UPDATE</button>
          <a href="{{ route('user.changepassword') }}" class="btn btn-default">Ganti Password</a>
        </div>
      </div>
    </div>
  </form>
@stop
@section('includejs')
@parent
  <script src="../js/tinymce/tinymce.min.js" type="text/javascript"></script>
@stop
@section('javascript')
  @parent    
    tinymce.init({
        selector: "textarea#contactbox",
        theme: "modern",
        menubar: false,
        plugins: "fullscreen,table,textcolor,media,searchreplace,code,autoresize,image,link",
        toolbar: "styleselect | bold italic underline strikethrough | searchreplace | link image | code | fullscreen"
    });
@stop

