@extends('layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection
@section('title')
    معلومات الفاتورة
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    معلومات الفاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if (session()->has('delete'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('delete') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if (session()->has('Add'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('Add') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif


<div class="panel panel-primary tabs-style-2">
	<div class=" tab-menu-heading">
		<div class="tabs-menu1">
			<!-- Tabs -->
			<ul class="nav panel-tabs main-nav-line">
				<li><a href="#tab4" class="nav-link active" data-toggle="tab">معلومات الفاتورة</a></li>
				<li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الدفع</a></li>
				<li><a href="#tab6" class="nav-link" data-toggle="tab">المرفقات</a></li>
			</ul>
		</div>
	</div>
	<div class="panel-body tabs-menu-body main-content-body-right border">
		<div class="tab-content">
			<div class="tab-pane active" id="tab4">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap">
                        <tbody>
                            <tr>
                                <td>رقم الفاتورة</td>
                                <td>{{ $invoices->invoice_number }}</td>
                                <td>تاريخ الاصدار</td>
                                <td>{{ $invoices->invoice_data }}</td>
                                <td>تاريخ الاستحقاق</td>
                                <td>{{ $invoices->due_data }}</td>
                                <td>القسم</td>
                                <td>{{ $invoices->sections->section_name }}</td>
                            </tr>
                            <tr>
                                <td>المنتج</td>
                                <td>{{ $invoices->product }}</td>
                                <td>مبلغ التحصيل</td>
                                <td>{{ $invoices->Amount_Collection }}</td>
                                <td>مبلغ العموله</td>
                                <td>{{ $invoices->Amount_Commission }}</td>
                                <td>الخصم</td>
                                <td>{{ $invoices->Discount }}</td>
                            </tr>
                            <tr>
                                <td>نسبة الضريبه</td>
                                <td>{{ $invoices->Rate_VAT }}</td>
                                <td>قيمة الضريبة</td>
                                <td>{{ $invoices->Value_VAT }}</td>
                                <td>الاجمالى</td>
                                <td>{{ $invoices->Total }}</td>
                                <td>الحالة</td>
                                <td>
                                    @if ($invoices->value_status == 1)
                                        <span class="text-success">{{ $invoices->status }}</span>
                                    @elseif ($invoices->value_status == 2)
                                        <span class="text-danger">{{ $invoices->status }}</span>
                                    @else
                                        <span class="text-warning">{{ $invoices->status }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>المستخدم</td>
                                <td></td>
                                <td>ملاحظات</td>
                                <td>{{ $invoices->note }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
			</div>
			<div class="tab-pane" id="tab5">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">رقم الفاتورة</th>
                                <th class="border-bottom-0">المنتج</th>
                                <th class="border-bottom-0">القسم</th>
                                <th class="border-bottom-0">الحالة</th>
                                <th class="border-bottom-0">تاريخ الدفع</th>
                                <th class="border-bottom-0">ملاحظات</th>
                                <th class="border-bottom-0">تاريخ الفاتورة</th>
                                <th class="border-bottom-0">المستخدم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i=0;
                            @endphp
                            @foreach ($invoices_details as $invoices_detail)
                            @php ++$i @endphp
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $invoices_detail->invoice_number }}</td>
                                <td>{{ $invoices_detail->product }}</td>
                                <td>{{ $invoices->sections->section_name }}</td>
                                <td>
                                @if ($invoices_detail->value_status == 1)
                                    <span class="text-success">{{ $invoices_detail->status }}</span>
                                @elseif ($invoices_detail->value_status == 2)
                                    <span class="text-danger">{{ $invoices_detail->status }}</span>
                                @else
                                    <span class="text-warning">{{ $invoices_detail->status }}</span>
                                @endif
                                </td>
                                <td>{{$invoices_detail->Payment_date}}</td>
                                <td>{{ $invoices_detail->note }}</td>
                                <td>{{ $invoices_detail->created_at }}</td>
                                <td>{{ $invoices_detail->user }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
			</div>

			<div class="tab-pane" id="tab6">

                <div class="card card-statistics">
                    <div class="card-body">
                        <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                        <h5 class="card-title">المرفقات</h5>

                        <form method="post" action="{{url('/invoiceAttachment')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-sm-12 col-md-12">
                                <input type="file" name="pic" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                data-height="70" />
                                <input type="hidden" name="invoice_number" value="{{$invoices->invoice_number}}">
                                <input type="hidden" name="invoice_id" value="{{$invoices->id}}">
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">حفظ البيانات</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">اسم الملف</th>
                                <th class="border-bottom-0">قام بالاضافة</th>
                                <th class="border-bottom-0">تاريخ الاضافة</th>
                                <th class="border-bottom-0">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i=0;
                            @endphp
                            @foreach ($invoices_attachments as $invoices_attachment)
                            @php ++$i @endphp
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $invoices_attachment->file_name }}</td>
                                <td>{{ $invoices_attachment->created_by }}</td>
                                <td>{{ $invoices_attachment->created_at }}</td>
                                <td>
                                    <a href="{{ url('view_file') }}/{{$invoices->invoice_number}}/{{$invoices_attachment->file_name}}" class="btn btn-outline-success text-success"><i class="fas fa-eye"></i>عرض</a>
                                    <a href="{{ url('download') }}/{{$invoices->invoice_number}}/{{$invoices_attachment->file_name}}" class="btn btn-outline-info text-info"><i class="fas fa-download"></i> تحميل</a>
									<button
                                    class="modal-effect btn btn-outline-danger text-danger"
                                    data-effect="effect-sign" data-toggle="modal" href="#modaldemo8"
                                    data-invoice_number="{{$invoices->invoice_number}}"
                                    data-file_name="{{$invoices_attachment->file_name}}"
                                    data-id_file="{{$invoices_attachment->id}}"
                                    >حذف</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
			</div>
		</div>
	</div>
    <div class="modal" id="modaldemo8">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">حذف المرفق</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('delete_file') }}" method="post">

                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p class="text-center">
                        <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                        </p>

                        <input type="hidden" name="id_file" id="id_file" value="">
                        <input type="hidden" name="file_name" id="file_name" value="">
                        <input type="hidden" name="invoice_number" id="invoice_number" value="">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@stop

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
        $('#modaldemo8').on('show.bs.modal',function(event){
            var button = $(event.relatedTarget);
            var invoice_number = button.data('invoice_number');
            var file_name = button.data('file_name');
            var id_file = button.data('id_file');

        $(this).find('.modal-body #invoice_number').val(invoice_number);
        $(this).find('.modal-body #file_name').val(file_name);
        $(this).find('.modal-body #id_file').val(id_file);
        });
    </script>
@stop
