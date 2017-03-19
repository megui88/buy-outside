@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <form method="GET">
                            Soy de: {!! $selectFrom !!} y viaje a: {!! $selectTo !!} <button class="btn-link btn btn-sm" type="submit">cambiar</button>
                        </form>
                    </div>

                    <div class="panel-body">
                        <h1>Introduzca el importe en la moneda de {{ $to['country'] }}
                        </h1>
                        <div>
                            <input type="number" class="form-control input-lg" id="toAmount" placeholder="Ejemplo 1000 {{ $to['currency'] }}">
                            <h3 id="fromResult"></h3>
                            <h4 id="inCentralCurrency"></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="application/javascript">
        calcule();
        $('#toAmount').on('keyup',calcule);
        $('#toAmount').on('change',calcule);
        function calcule($amount) {
            var $to = {{ $to['value'] }},
                $from = {{ $from['value'] }},
                $amount = $('#toAmount').val();

            $('#fromResult').text(($amount/($to/$from)).toFixed(2) + ' {{ $from['currency'] }}');
            $('#inCentralCurrency').text(($amount/$to).toFixed(2) + '  {{ $dollar }}');
        }
    </script>
@endsection