@extends('layouts.master')
@section('title')
المنتجات
@stop
@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
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
				<!-- row -->
				<div class="row row-sm">
                    @if (session()->has('Add'))
                        <div class="alert alert-success alert-dismissible fade show d-block" role="alert">
                            <strong>{{session()->get('Add')}}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    @elseif (session()->has('Error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{session()->get('Error')}}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @elseif (session()->has('Edite'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{session()->get('Edite')}}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @elseif (session()->has('Delete'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{session()->get('Delete')}}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
					<!--div-->
					<div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-header pb-0">
                                <a class="modal-effect btn btn-outline-success btn-rounded" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">اضافة منتج</a>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="example1" class="table key-buttons text-md-nowrap" data-page-length="50">
										<thead>
											<tr>
												<th class="border-bottom-0">#</th>
												<th class="border-bottom-0">اسم المنتج</th>
												<th class="border-bottom-0">اسم القسم</th>
												<th class="border-bottom-0">الوصف</th>
												<th class="border-bottom-0">العمليات</th>
											</tr>
										</thead>
										<tbody>
                                            <?php $i=0?>
                                            @foreach ($prodacts as $prodact)
                                                <tr>
                                                    <td><?=++$i?></td>
                                                    <td>{{$prodact->prodact_name}}</td>
                                                    <td>{{$prodact->sections->section_name}}</td>
                                                    <td>{{$prodact->description}}</td>
                                                    <td>
                                                        <a class="modal-effect btn btn-success btn-sm rounded-0"
                                                        data-effect="effect-flip-vertical" data-toggle="modal" title="تعديل" href="#modaldemo7"
                                                        data-name="{{$prodact->prodact_name}}" data-id="{{$prodact->id}}" data-description="{{$prodact->description}}"
                                                        data-sec_id="{{$prodact->section_id}}"
                                                        ><i class="fa fa-edit"></i></a>
                                                        <a class="modal-effect btn btn-danger btn-sm rounded-0"
                                                        data-effect="effect-flip-vertical" data-toggle="modal" title="حذف" href="#modaldemo9"
                                                        data-id="{{$prodact->id}}" data-name="{{$prodact->prodact_name}}"
                                                        ><i class="fa fa-trash"></i></a>
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

                    		<!-- create modal -->
                            <div class="modal" id="modaldemo8">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content modal-content-demo">
                                        <div class="modal-header">
                                            <h6 class="modal-title">اضافة منتج</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                                type="button"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('prodacts.store') }}" method="post">
                                                @csrf

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">اسم المنتج</label>
                                                    <input type="text" class="form-control" id="prodact_name" name="prodact_name">
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">اسم القسم</label>
                                                    <select class="form-control" name="section_id">
                                                        <option selected>اختر القسم</option>
                                                        @foreach ($sections as $section)
                                                        <option value="{{$section->id}}">{{$section->section_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleFormControlTextarea1">ملاحظات</label>
                                                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">تاكيد</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
				            </div>
                            <!-- End create modal -->


                          {{-- edite model --}}
                            <div class="modal" id="modaldemo7">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content modal-content-demo">
                                        <div class="modal-header">
                                            <h6 class="modal-title">تعديل المنتج</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                                type="button"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="prodacts/update" method="post" autocomplete="off">
                                                {{method_field('PUT')}}
                                                @csrf

                                                <div class="form-group">
                                                    <input type="hidden" id="id" name="id">
                                                    <label for="exampleInputEmail1">اسم المنتج</label>
                                                    <input type="text" class="form-control" id="prodact_name" name="prodact_name">
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">اسم القسم</label>
                                                    <select class="form-control" id="sec_id" name="section_id">
                                                        <option selected>اختر القسم</option>
                                                        @foreach ($sections as $section)
                                                        <option value="{{$section->id}}">{{$section->section_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleFormControlTextarea1">ملاحظات</label>
                                                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">تاكيد</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
				            </div>
                          {{-- End edite model --}}
                          {{-- delete model --}}
                            <div class="modal" id="modaldemo9">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content modal-content-demo">
                                        <div class="modal-header">
                                            <h6 class="modal-title">حذف المنتج</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                                type="button"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="prodacts/destroy" method="post">
                                                {{method_field('delete')}}
                                                @csrf

                                                <div class="form-group">
                                                    <input type="hidden" id="id" name="id">
                                                    <p>هل انت متاكد من حذف هذا المنتج؟</p>
                                                    <input type="text" class="form-control" id="prodact_name" name="prodact_name">
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-danger">تاكيد</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
				            </div>
                          {{-- End delete model --}}

				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
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
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>

<script>
    $('#modaldemo7').on('show.bs.modal',function(event){
        var button = $(event.relatedTarget);
        var prodact_name = button.data('name');
        var sec_id = button.data('sec_id');
        var description = button.data('description');
        var id = button.data('id');

        $(this).find('.modal-body #prodact_name').val(prodact_name);
        $(this).find('.modal-body #sec_id').val(sec_id);
        $(this).find('.modal-body #description').val(description);
        $(this).find('.modal-body #id').val(id);
    });

    $('#modaldemo9').on('show.bs.modal',function(event){
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var prodact_name = button.data('name');


        $(this).find('.modal-body #id').val(id);
        $(this).find('.modal-body #prodact_name').val(prodact_name);

    });
</script>
@endsection
