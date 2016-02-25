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
  <form class="form-horizontal" id="myForm" method="POST" action="{{ route('user.doconfirmpayment') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="row">
      <div class="col-lg-6">
        <div class="well bs-component">
            <fieldset>
              <legend>KONFIRMASI PEMBAYARAN REGISTRASI</legend>
              <ul>
                <li>Pastikan bahwa {{ $user->first_name}} sudah transfer sebelum melakukan konfirmasi pembayaran ini.</li>
                <li>Format tanggal dalam tahun-bulan-hari (yyyy-mm-dd). Contoh: untuk tanggal 25 Januari 2016 isi kolom dengan <strong>2016-01-25</strong> </li>
                <li>Untuk mempermudah ADMIN melakukan pengecekan dan mempercepat konfirmasi lunas, silahkan tambahkan angka <strong>{{ $user->lasttwodigit }}</strong> ini disaat Anda transfer.</li>
                <li>Jumlah yang mesti {{ $user->first_name }} transfer {{ $jmltransfer }}</li>
              </ul>
              <div class="form-group">
                <label for="inputJmlTransfer" class="col-lg-2 control-label">Jumlah</label>
                <div class="col-lg-10">
                  <input type="text" name="jmltransfer" class="form-control" id="inputJmlTransfer" placeholder="Jumlah yang Anda transfer" value="{{ old('jmltransfer') }}" />
                </div>
              </div>

              <div class="form-group">
                <label for="inputBankTujuan" class="col-lg-2 control-label">Transfer Ke </label>
                <div class="col-lg-10">
                  <select name="banktujuan" class="form-control" id="inputBankTujuan">
                    <option value="" selected="true">-- Pilih bank tujuan transfer --</option>
                    {!! $bank_tujuan !!}
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="inputTglTransfer" class="col-lg-2 control-label">Tgl Transfer</label>
                <div class="col-lg-10">
                  <input type="text" name="tgltransfer" class="form-control" id="inputTglTransfer" placeholder="Tanggal transfer" value="{{ old('tgltransfer') }}" />
                </div>
              </div>

            </fieldset>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="well bs-component">
            <fieldset>
              <legend>REKENING PENGIRIM</legend>
              <div class="form-group">
                <label for="inputRekNo" class="col-lg-2 control-label">Nomor Rekening</label>
                <div class="col-lg-10">
                  <input type="text" name="rekNo" class="form-control" id="inputRekNo" placeholder="Nomor Rekening" value="{{ old('rekNo') }}" />
                </div>
              </div>

              <div class="form-group">
                <label for="inputRekNama" class="col-lg-2 control-label">Atas Nama</label>
                <div class="col-lg-10">
                  <input type="text" name="rekNama" class="form-control" id="inputRekNama" placeholder="Rekening atas nama" value="{{ old('rekNama') }}" />
                </div>
              </div>

              <div class="form-group">
                <label for="inputRekBank" class="col-lg-2 control-label">Bank</label>
                <div class="col-lg-10">
                  <input type="text" name="rekBank" class="form-control" id="inputRekBank" placeholder="Bank" value="{{ old('rekBank') }}" />
                </div>
              </div>
            </fieldset>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="form-group">
        <div class="col-lg-10 col-lg-offset-2">
          <button type="submit" class="btn btn-primary">KIRIM KONFIRMASI</button>
        </div>
      </div>
    </div>
  </form>
@stop
@section('includejs')
@parent
  <script src="../js/jquery.maskMoney.min.js" type="text/javascript"></script>
  <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
  <script src="../js/jquery.datetimepicker.js"></script>
@stop
@section('javascript')
  @parent    
    $('#inputJmlTransfer').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
    $('#inputTglTransfer').datetimepicker({
        format:'Y-m-d',mask:false,
        timepicker:false,
        lang:'id'
    });
@stop

