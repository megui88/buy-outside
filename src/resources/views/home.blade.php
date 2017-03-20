@extends('layout')

@section('content')
    <div class="container-flow">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <form method="GET">
                            <div class="row">
                                <div class="col-xs-5 col-sm-3">
                                    <label for="from">De donde sos?</label> {!! $selectFrom !!}
                                </div>
                                <div class="col-xs-5 col-sm-3">
                                    <label for="to">A donde viajas?</label> {!! $selectTo !!}
                                </div>
                                <div class="col-xs-2 col-sm-4">
                                    <button class="btn-link btn btn-xs" type="submit">cambiar</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="panel-body">
                        <label for="toAmount">Introduzca el importe en la moneda de {{ $to['country'] }}</label>
                        <div>
                            <input type="number" class="form-control input-lg" id="toAmount" placeholder="Ejemplo 1000 {{ $to['currency'] }}"  data-dependency="fromResult">
                            <label for="toAmount">
                                <h3 id="fromResult" style="color: green"></h3>
                                <h4 id="inCentralCurrency" style="color: red"></h4>
                            </label>
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
        $('#toAmount').on("keydown",function(event){
            if (event.keyCode == 9) {
                $('#fromResult').focus();
                return false;
            }
            if (event.keyCode == 13) {
                console.log('wololoo');
                $('#fromResult').focus();
                return false;
            }
        });
    </script>
@endsection