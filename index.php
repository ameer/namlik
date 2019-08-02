<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Namlik Downloader</title>
    <link rel="stylesheet" href="css/bootstrap-rtl.min.css">
</head>

<body>
    <div class="container text-center my-2 rtl">
        <h2 class="text-info">از ناملیک پادکست دانلود کنید!</h2>
        <p class="text-muted">
            کافیه برید تو صفحه هر پادکست و آدرسش رو مثل نمونه زیر کپی و اینجا پیست کنید
        </p>
        <p class="text-monospace " style="direction:ltr !important">http://namlik.me/article/چگونه کدهای قابل نگهداری بنویسیم؟ قسمت دوم</p>
    </div>

    <div class="container py-3">
        <div class="row">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="url_input" placeholder="Podcast URL" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" id="download-button" type="button" onclick="get_data()">Download</button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 offset-md-3 text-center rtl d-none" id="loading">
                <div class="spinner-grow" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="col-12 col-md-6 offset-md-3 rtl d-none" id="podcast">
                <h3 id="title"></h3>
                <img class="img-fluid" id="cover" src="" alt="">
                <audio class="w-100 mb-1" src="" id="mp3_player" controls></audio>
                <p class="lead" id="desc"></p>
            </div>
        </div>
    </div>
    <div class="fixed-bottom text-center bg-light">
        <p class="lead py-2 my-0">Designed and built with <span class="text-danger">♥</span> by Ameer Mousavi. Licensed under the MIT License.</p>
    </div>
    <script>
        var $ = document.querySelector.bind(document),
            url_input = $("#url_input"),
            dl_btn = $("#download-button"),
            podcast = $("#podcast"),
            loading = $("#loading"),
            title = $("#title"),
            cover = $("#cover"),
            desc = $("#desc"),
            player = $("#mp3_player");

        function ajax_request(method, url, data, callback, is_json = true) {
            var request = new XMLHttpRequest();
            request.open(method, url, true);
            if (method.toLowerCase() == "post") {
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            }
            loading.classList.remove("d-none");
            podcast.classList.add("d-none");
            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    // Success!
                    if (is_json == false) {
                        var data = request.responseText;
                    } else {
                        var data = JSON.parse(request.responseText);
                    }
                    callback(data);
                } else {
                    ajax_error_handler(request);
                    return false;
                }
            };
            request.send("data=" + data);
            request.onerror = function() {
                loading.classList.add("d-none");
            }
        }

        function add_data(json) {

            if (json.success) {
                podcast.classList.remove("d-none");
                loading.classList.add("d-none");
                title.innerHTML = json.title;
                //cover.src = json.image;
                desc.innerHTML = json.description;
                player.src = json["video:url"];
                player.type = "audio/mp3";
            } else {
                loading.classList.add("d-none");
                alert(json.error);
            }
        }
        function get_data() {
            var podcast_url = url_input.value;
            if (podcast_url != "") {
                var data = {
                    url: podcast_url
                }
                ajax_request("post", "ajax.php", JSON.stringify(data), add_data)
            }
        }
    </script>
</body>

</html>