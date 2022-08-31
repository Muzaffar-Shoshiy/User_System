<?php

    require_once "assets/php/admin-header.php";

?>
            <div class="row justify-content-center my-2">
                <div class="col-lg-6 mt-4" id="notification">

                </div>
            </div>
            <!-- footer area -->
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){

            // FETCH NOTIFICATION
            fetchNotification() 
            function fetchNotification(){
                $.ajax({
                    url: "assets/php/admin-action.php",
                    method:"post",
                    data:{action:'fetchNotification'},
                    success:function(response){
                        $("#notification").html(response)
                    }
                })
            }
            // check notification
            checkNotification()
            function checkNotification(){
                $.ajax({
                    url: "assets/php/admin-action.php",
                    method:"post",
                    data:{action: "checkNotification"},
                    success:function(response){
                        $("#checkNotification").html(response)
                    }
                })
            }
            // remove notification
            $("body").on("click",".close",function(e){
                e.preventDefault()
                notification_id = $(this).attr("id")
                $.ajax({
                    url: "assets/php/admin-action.php",
                    method:"post",
                    data: {notification_id:notification_id},
                    success:function(response){
                        fetchNotification()
                        checkNotification()
                    } 
                })
            })
        })
    </script>
</body>
</html>
