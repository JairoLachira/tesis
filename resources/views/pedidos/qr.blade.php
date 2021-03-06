@extends('layouts.app-r')

@section('content')
<section>

    <div class="container">
        <div class="menu">
            <div class="cameras">
                 <h2>Camaras</h2>
                 <div id="camerasList">

                 </div>
            </div>
        </div>

        <center>
        <h2>Muestre su codigo para confirmar pedido</h2>
        <div class="preview-container">
            <video id="preview"></video>
            <div id="line" class="line"></div>
        </div>
        </center>

        <div class="scans">
            <div id="scans">
                <h2>Scans</h2>
            </div>
        </div>

    </div>

</section>

@endsection

{{-- SCRIPTS JS PARA LA WEBCAM --}}
<script src="{{ asset('js/webcam/instascan.min.js') }}" ></script>
<script src="{{ asset('js/webcam/app.js') }}" ></script>



