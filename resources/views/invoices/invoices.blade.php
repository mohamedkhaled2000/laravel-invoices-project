@extends('layouts.master')
@section('title')
 قائمة الفواتير
@stop
@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!--Internal   Notify -->
<link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
<!--Internal  treeview -->
<link href="{{URL::asset('assets/plugins/treeview/treeview.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الفواتير</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')


                @if (session()->has('deleted'))

                    <script>
                        window.onload = function(){
                            notif({
                                msg: "تم حذغ الفاتورة بنجاح",
                                type: 'success'
                            })
                        }
                    </script>

                @endif
                @if (session()->has('archive'))

                    <script>
                        window.onload = function(){
                            notif({
                                msg: "تم ارشفه الفاتورة بنجاح",
                                type: 'success'
                            })
                        }
                    </script>

                @endif
                @if (session()->has('restore_archive'))

                    <script>
                        window.onload = function(){
                            notif({
                                msg: "تم الغاء ارشفه الفاتورة بنجاح",
                                type: 'success'
                            })
                        }
                    </script>

                @endif
				<!-- row -->
				<div class="row row-sm">

					<!--div-->
					<div class="col-xl-12">
						<div class="card mg-b-20">
                            <div class="col-sm-6 col-md-3">
                                @can('اضافة فاتورة')
                                <a href="invoices/create" class="btn btn-primary btn-block">اضافة فاتورة</a>
                                @endcan

                                @can('تصدير EXCEL')
                                <a href="{{ url('export_invoice') }}" class="btn btn-success btn-block">تصدير الفواتير</a>
                                @endcan

                            </div>
							<div class="card-body">
								<div class="table-responsive">
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
												<th class="border-bottom-0">العمليات</th>
											</tr>
										</thead>
										<tbody>
                                            @php
                                                $i=0;
                                            @endphp
                                            @foreach ($invoices as $invoice)
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
												<td>
                                                    <div class="dropdown">
                                                        <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary"
                                                        data-toggle="dropdown" id="dropdownMenuButton" type="button">العمليات <i class="fas fa-caret-down ml-1"></i></button>
                                                        <div  class="dropdown-menu tx-13">
                                                                @can('تعديل الفاتورة')
                                                                    <a class="dropdown-item btn text-primary btn-block" href="{{route('invoice_edit',$invoice->id)}}">تعديل الفاتورة</a>
                                                                @endcan

                                                                @can('حذف الفاتورة')
                                                                    <a class="dropdown-item modal-effect btn text-danger btn-block" data-effect="effect-scale" data-invoice_id="{{$invoice->id}}" data-toggle="modal" href="#modaldemo8">حذف الفاتورة</a>
                                                                @endcan

                                                                @can('تغير حالة الدفع')
                                                                    <a class="dropdown-item btn text-success btn-block" href="{{route('status_show',$invoice->id)}}">تغير حالة الفاتورة</a>
                                                                @endcan

                                                                @can('ارشفة الفاتورة')
                                                                    <a class="dropdown-item modal-effect btn text-warning btn-block" data-effect="effect-scale" data-invoice_id="{{$invoice->id}}" data-toggle="modal" href="#modaldemo7"> نقل للارشيف</a>
                                                                @endcan

                                                                @can('طباعةالفاتورة')
                                                                    <a class="dropdown-item btn text-success btn-block" href="{{route('printInvoice',$invoice->id)}}"> طباعة الفاتورة</a>
                                                                @endcan
                                                        </div>
                                                    </div>
                                                </td>
											</tr>
                                            @endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!--/div-->


                    {{-- deleting invoice model --}}
                    <div class="modal" id="modaldemo8">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">حذف الفاتورة</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                    <form action="{{ route('invoices.destroy', 'test') }}" method="post">                                        {{ method_field('delete') }}
                                        @csrf
                                </div>
                                    <div class="modal-body">
                                        <p>هل انت متاكد من حذف هذه الفاتورة؟.</p>
                                        <input type="hidden" name="invoice_id" id="invoice_id" value="">
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">الغاء</button>
                                        <button class="btn ripple btn-danger" type="submit">تاكيد</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                    {{-- move invoice to archive --}}
                    <div class="modal" id="modaldemo7">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">ارشفه الفاتورة</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                    <form action="{{ route('invoices.destroy', 'test') }}" method="post">                                        {{ method_field('delete') }}
                                        @csrf
                                </div>
                                    <div class="modal-body">
                                        <p>هل انت متاكد من ارشفة هذه الفاتورة؟.</p>
                                        <input type="hidden" name="invoice_id" id="invoice_id" value="">
                                        <input type="hidden" name="page_id" id="page_id" value="2">
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">الغاء</button>
                                        <button class="btn ripple btn-success" type="submit">تاكيد</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

				</div>
				<!-- row closed -->

@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<script src="{{URL::asset('assets/js/modal.js')}}"></script>

<!-- Internal Treeview js -->
<script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
<!--Internal  Notify js -->
<script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
<script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>


<script>
    $('#modaldemo8').on('show.bs.modal',function(event){
        var button = $(event.relatedTarget);
        var invoice_id = button.data('invoice_id');

        $(this).find('.modal-body #invoice_id').val(invoice_id);
    });

    $('#modaldemo7').on('show.bs.modal',function(event){
        var button = $(event.relatedTarget);
        var invoice_id = button.data('invoice_id');

        $(this).find('.modal-body #invoice_id').val(invoice_id);
    });
</script>
@endsection
