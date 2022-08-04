            </div>
            <!-- /#page-content-wrapper -->

        </div>
        <!-- /#wrapper -->

        <script type="text/javaScript" src="<?php echo site_url('private/js/bootstrap.min.js'); ?>"></script>

        <!-- All plugins -->
        <script type="text/javaScript" src="<?php echo site_url('private/plugins/bootstrap-fileinput-master/js/fileinput.min.js') ;?>"></script>
        <!-- <script type="text/javaScript" src="<?php //echo site_url('private/plugins/peity/jquery.peity.min.js')?>"></script> -->

    	<!-- Nice Scroll -->
    	<script src="<?php echo site_url('private/js/jquery.nicescroll.min.js'); ?>"></script>

        


        <!-- Menu Toggle Script -->
        <script type="text/javaScript">
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
                $("#wrapper").toggleClass("toggled");
                $(this).toggleClass("icon-change");
            });

            $(function () {
                $('#datetimepicker1').datetimepicker({
                    format: 'YYYY-MM-DD'
                });

                // charte

                // var updatingChart = $(".bar").peity("bar", {
                // width: 200,
                // height: 100
            });
            // setInterval(function() {
            //     var random = Math.round(Math.random() * 10);
            //     var values = updatingChart.text().split(",");
            //     values.shift();
            //     values.push(random);
            //
            //     updatingChart.text(values.join(",")).change();
            // }, 1000);

                // $(".bar1").peity("bar");
                //
                // $("span.pie").peity("pie");
                //
                // $(".data-attributes span").peity("donut")


                // linking between two date
                $('#datetimepickerFrom').datetimepicker();
                $('#datetimepickerTo').datetimepicker({
                    useCurrent: false
                });
                $("#datetimepickerFrom").on("dp.change", function (e) {
                    $('#datetimepickerTo').data("DateTimePicker").minDate(e.date);
                });
                $("#datetimepickerTo").on("dp.change", function (e) {
                    $('#datetimepickerFrom').data("DateTimePicker").maxDate(e.date);
                });

            // file upload with plugin options
            $("input#input").fileinput({
                browseLabel: "Pick Image",
                previewFileType: "text",
                allowedFileExtensions: ["jpg", "jpeg", "png"],
            });




        </script>

        <script>
        $(document).on('ready', function() {
            $("#input-4").fileinput({showCaption: false});
        });
    // print option start here
        $('.row.hide .col-xs-3.col-sm-3').addClass('position');
        $('.row.hide img').css({
            height: '110px',
            marginTop: '0px',
            float: 'left'
        });
        $('.row.hide .col-xs-3').css({
            position: 'absolute',
        });
        $('.row.hide .col-xs-4').css({
            position: 'absolute',
        });
        $('.row.hide .col-xs-4').removeClass('col-xs-offset-1')
        $('.row.hide .col-sm-4').removeClass('col-sm-offset-1')
        
        $('.hide h2').css({
            padding: '0px',
            margin: '0px',
            textAlign: 'center',
            fontSize: '40px',
            letterSpacing: '2px'
        });
        $('.hide h4').css({
            paddingLeft: '0px',
            textAlign: 'center'
        });
        $('.row.hide img').attr('width', '110');
        $('.row.hide .col-sm-7').removeClass('col-xs-7');
        $('.row.hide .col-sm-7').addClass('col-xs-12');
        $('.row.hide .col-xs-12').removeClass('col-sm-7');
        $('.row.hide .col-xs-12').addClass('col-sm-12');
        
        $('.row.hide .mymymy').css({
            height: '80px',
            width: '80px',
            marginTop: '0px',
            float: 'left'
        });
    // print option end here
    // Script Styling not a good way.
        </script>
    </body>
</html>
