@extends('layouts.master')
@section('css')
    /*Internal Select2 css*/
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    {{--    Internal Fileupload css--}}
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    {{--    <!---Internal Fancy uploader css-->--}}
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    {{--    <!--Internal Sumoselect css-->--}}
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    {{--    <!--Internal  TelephoneInput css-->--}}
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection

@section('title')
    التقارير
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">التقارير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تقارير الفواتير</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <form action="{{ route('invoices_search') }}" method="post" >
                @csrf

                <div class="col-lg-3">
                    <label class="rdiobox">
                        <input checked name="rdio" type="radio" value="1" id="type_div"> <span>بحث بنوع
                                الفاتورة</span></label>
                </div>


                <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                    <label class="rdiobox"><input name="rdio" value="2" type="radio"><span>بحث برقم الفاتورة
                            </span></label>
                </div><br><br>

                <div class="row">
                    <div class="col-lg-3 mg-t-20 mg-lg-t-0" id="type">
                        <p class="mg-b-10">تحديد نوع الفواتير</p><select class="form-control select2" name="type"
                                                                         required>
                            <option value="{{ $type ?? 'حدد نوع الفواتير' }}" selected>
                                {{ $type ?? 'حدد نوع الفواتير' }}
                            </option>

                            <option value="مدفوعة">الفواتير المدفوعة</option>
                            <option value="غير مدفوعة">الفواتير الغير مدفوعة</option>
                            <option value="مدفوعة جزئيا">الفواتير المدفوعة جزئيا</option>

                        </select>
                    </div><!-- col-4 -->

                    <div class="col-lg-3 mg-t-20 mg-lg-t-0" id="invoice_number">
                        <p class="mg-b-10">البحث برقم الفاتورة</p>
                        <input type="text" class="form-control" id="invoice_number" name="invoice_number">

                    </div><!-- col-4 -->

                    <div class="col" id="start_at">
                        <label>من تاريخ</label>
                        <input class="form-control fc-datepicker" name="start_at" placeholder="YYYY-MM-DD"
                              value="{{ $start_at ?? '' }}" type="text">
                    </div>

                    <div class="col" id="end_at">
                        <label>الى تاريخ</label>
                        <input class="form-control fc-datepicker" name="end_at" placeholder="YYYY-MM-DD"
                               value="{{ $end_at ?? '' }}"  type="text">
                    </div>
                </div><br>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">بحث</button>
                </div>
            </form>
        </div>
    </div>
    <!-- row closed -->

    <div class="card-body">
        <div class="table-responsive">
            @if(isset($details))
            <table id="example1" class="table key-buttons text-md-nowrap">
                <thead>
                <tr>
                    <th class="border-bottom-0">#</th>
                    <th class="border-bottom-0">رقم الفاتورة</th>
                    <th class="border-bottom-0">تاريخ الفاتورة</th>
                    <th class="border-bottom-0">تاريخ الاستحقاق</th>
                    <th class="border-bottom-0">المنتج</th>
                    <th class="border-bottom-0">القسم</th>
                    <th class="border-bottom-0">الخصم</th>
                    <th class="border-bottom-0">نسبة الضريبة</th>
                    <th class="border-bottom-0">قيمة الضريبة</th>
                    <th class="border-bottom-0">الاجمالى</th>
                    <th class="border-bottom-0">الحالة</th>
                    <th class="border-bottom-0">ملاحظات</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $i=0;
                @endphp
                @foreach ($details as $invoice)
                    @php ++$i @endphp
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $invoice->invoice_number }}</td>
                        <td>{{ $invoice->invoice_data }}</td>
                        <td>{{ $invoice->due_data }}</td>
                        <td>{{ $invoice->product }}</td>
                        <td>
                            <a href="{{ url('invoicesDetails') }}/{{ $invoice->id }}">{{ $invoice->sections->section_name }}</a>
                        </td>
                        <td>{{ $invoice->Discount }}</td>
                        <td>{{ $invoice->Rate_VAT }}</td>
                        <td>{{ $invoice->Value_VAT }}</td>
                        <td>{{ $invoice->Total }}</td>
                        <td>
                            @if ($invoice->value_status == 1)
                                <span class="text-success">{{ $invoice->status }}</span>
                            @elseif ($invoice->value_status == 2)
                                <span class="text-danger">{{ $invoice->status }}</span>
                            @else
                                <span class="text-warning">{{ $invoice->status }}</span>
                            @endif
                        </td>
                        <td>{{ $invoice->note }}</td>

                    </tr>
                @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

@endsection
@section('js')

    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

    <script>
        $(document).ready(function (){
            $('#invoice_number').hide();

            $('input[type="radio"]').click(function (){
                if ($(this).attr('id') == 'type_div'){
                    $('#invoice_number').hide();
                    $('#type').show();
                    $('#start_at').show();
                    $('#end_at').show();
                }else {
                    $('#invoice_number').show();
                    $('#type').hide();
                    $('#start_at').hide();
                    $('#end_at').hide();
                }
            });
        });
    </script>
@endsection
