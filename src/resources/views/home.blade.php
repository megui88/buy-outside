@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <form method="GET">
                            <label for="from">De donde sos?</label> {!! $selectFrom !!} <label for="to">De donde sos?</label> {!! $selectTo !!} <button class="btn-link btn btn-sm" type="submit">cambiar</button>
                        </form>
                    </div>

                    <div class="panel-body">
                        <label for="toAmount">Introduzca el importe en la moneda de {{ $to['country'] }}</label>
                        <div>
                            <form action="javascript: false;">
                            <input type="number" class="form-control input-lg" id="toAmount" placeholder="Ejemplo 1000 {{ $to['currency'] }}">
                            </form>
                            <h3 id="fromResult" style="color: green"></h3>
                            <h4 id="inCentralCurrency" style="color: red"></h4>
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