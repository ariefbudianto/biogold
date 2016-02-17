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
              <legend>PROFILE</legend>
              <div class="form-group">
                <label for="inputRekNo" class="col-lg-12 control-label">Link Afiliasi : {{ url('/').'/?ref='.$user->username }}</label>
              </div>
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
                  <input type="text" name="handphone" class="form-control" id="inputHandphone" placeholder="Nomor handphone" value="{{ $user->handphone }}" />
                </div>
              </div>

              <div class="form-group">
                <label for="inputAddress1" class="col-lg-2 control-label">Alamat </label>
                <div class="col-lg-10">
                  <input type="text" name="address1" class="form-control" id="inputAddress1" placeholder="Alamat" value="@if ($errors->first('address1')) : {{ $user->address1 }} @endif" />
                </div>
              </div>

              <div class="form-group">
                <label for="inputAddress2" class="col-lg-2 control-label">&nbsp; </label>                    
                <div class="col-lg-10">
                  <input type="text" name="address2" class="form-control" id="inputAddress2" placeholder="Lanjutan alamat (opsional)" value="{{ $user->address2 }}" />
                </div>
              </div>
              
              <div class="form-group">
                <label for="inputCity" class="col-lg-2 control-label">Kota </label>
                <div class="col-lg-10">
                  <input type="text" name="city" class="form-control" id="inputCity" placeholder="Kota" value="{{ $user->city }}" />
                </div>
              </div>
              
              <div class="form-group">
                <label for="inputProvince" class="col-lg-2 control-label">Propinsi </label>
                <div class="col-lg-10">
                  <input type="text" name="province" class="form-control" id="inputProvince" placeholder="Propinsi" value="{{ $user->province }}" />
                </div>
              </div>
              
              <div class="form-group">
                <label for="inputCountry" class="col-lg-2 control-label">Negara </label>
                <div class="col-lg-10">
                  <input type="text" name="country" class="form-control" id="inputCountry" placeholder="Negara" value="{{ $user->country }}" />
                </div>
              </div>
            </fieldset>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="well bs-component">
            <fieldset>
              <legend>REKENING BANK</legend>
              <div class="form-group">
                <label for="inputRekNo" class="col-lg-2 control-label">Nomor Rekening</label>
                <div class="col-lg-10">
                  <input type="text" name="rekNo" class="form-control" id="inputRekNo" placeholder="Nomor Rekening" value="" />
                </div>
              </div>

              <div class="form-group">
                <label for="inputRekNama" class="col-lg-2 control-label">Atas Nama</label>
                <div class="col-lg-10">
                  <input type="text" name="rekNama" class="form-control" id="inputRekNama" placeholder="Rekening atas nama" value="" />
                </div>
              </div>

              <div class="form-group">
                <label for="inputRekBank" class="col-lg-2 control-label">Bank</label>
                <div class="col-lg-10">
                  <input type="text" name="rekBank" class="form-control" id="inputRekBank" placeholder="Bank" value="" />
                </div>
              </div>
              
              <div class="form-group">
                <label for="inputRekCabang" class="col-lg-2 control-label">Cabang </label>
                <div class="col-lg-10">
                  <input type="text" name="rekCabang" class="form-control" id="inputRekCabang" placeholder="Cabang" value="" />
                </div>
              </div>
              
              <div class="form-group">
                <label for="inputRekKota" class="col-lg-2 control-label">Kota </label>
                <div class="col-lg-10">
                  <input type="text" name="rekKota" class="form-control" id="inputRekKota" placeholder="Kota asal bank" value="" />
                </div>
              </div>

              <legend>CONTACT BOX</legend>
              <div class="form-group">
                <div class="col-lg-12">
                  <textarea class="form-control" rows="3" id="textArea" placeholder="Bila dikosongkan akan diisi default (nama, email dan nomor handphone Anda)."></textarea>
                  <span class="help-block">Isi <em>contact box</em> ini akan muncul otomatis pada halaman website promosi sesuai parameter referral yang diberikan.</span>
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
          <button type="reset" class="btn btn-default">Batal</button>
          <button type="submit" class="btn btn-primary">UPDATE</button>
        </div>
      </div>
    </div>
  </form>
@stop
