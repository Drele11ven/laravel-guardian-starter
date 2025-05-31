@extends('')
@section('body')
    <section class="container socialhead py-lg-1 py-2">
        <div class="row my-lg-3 my-2">
            <div class="col-lg-12 bg-light path">
                <ul>
                    <li><a href="#">صفحه اصلی</a><i class="fal fa-angle-left mr-3"></i></li>
                    <li><a href="#" class="active">خطای 404</a></li>
                </ul>
            </div>
        </div> 
    </section>
    <section class="container-fluid ">
        <div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-4">
                <div class="text-center er404 py-5">
                    <img src="{{ asset($image ?? 'takin/Img/404.png') }}" class="img-fluid" alt="Error Image" />

                    <h1 class="mt-4 mb-3">{{ $title ?? 'خطا' }}</h1>
                    <p class="mb-4">{{ $message ?? 'مشکلی پیش آمده است. لطفاً بعداً دوباره تلاش کنید.' }}</p>

                    <a class="btn bg-bro text-white px-3 fa12 radius15" href="{{ url('/') }}">
                        بازگشت به صفحه اصلی
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

    </section>
@endsection