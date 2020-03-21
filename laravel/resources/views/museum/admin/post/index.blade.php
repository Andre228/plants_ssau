@extends('layouts.app')

@section('content')

    <?php
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $url_components = parse_url($actual_link);

    if(isset($url_components['query'])) {
        parse_str($url_components['query'], $params);
        if($params['success_deleted']) {

            $response_message = $params['success_deleted'];

            echo '
                 <div class="row justify-content-center success-block">
                    <div class="col-md-11">
                        <div class="alert alert-success" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true" onclick="closeNotify()">x</span>
                            </button>
                            <div>'. $response_message .'</div>
                        </div>
                    </div>
                </div>';
        }
    }

    ?>

    <posts-component :posts="{{$postsList}}"></posts-component>

@endsection
<script>

    function closeNotify() {
        window.history.pushState('pageAdminMuseumPosts', 'closeNotify', '/admin/museum/posts');
        console.log(123);
    }

</script>