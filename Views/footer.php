<script src="./Assets/js/popper.min.js"></script>
<script src="./Assets/js/bootstrap.min.js"></script>
<script src="./Assets/js/main.js"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="./Assets/js/plugins/pace.min.js"></script>
<script type="text/javascript" src="./Assets/js/plugins/bootstrap-notify.min.js"></script>
<script type="text/javascript" src="./Assets/js/plugins/sweetalert.min.js"></script>
<!-- Page specific javascripts-->
<!-- Google analytics script-->
<script type="text/javascript">
    if (document.location.hostname == 'pratikborsadiya.in') {
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-72504830-1', 'auto');
        ga('send', 'pageview');
    }
</script>
<!-- Data table plugin-->
<script type="text/javascript" src="./Assets/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="./Assets/js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
        var table = $('#sampleTable').DataTable({
        //scrollY: '34vh',
        //scrollCollapse: true,
        language: {
            lengthMenu: 'Mostrar _MENU_ registros por pagina',
            zeroRecords: 'No existen registros',
            info: 'Mostrando pagina _PAGE_ de _PAGES_',
            infoEmpty: 'No existen registros',
            infoFiltered: '(filtrados de los _MAX_ registros totales)',
        },
        lengthMenu: [
            [10, 25, 50, 100], //cantidad
            [10, 25, 50, 100],//texto que se muestra
        ],
    });
//    $('a.toggle-vis').on('click', function (e) {
//        e.preventDefault();
// 
//        // Get the column API object
//        var column = table.column($(this).attr('data-column'));
// 
//        // Toggle the visibility
//        column.visible(!column.visible());
//    });
    </script>
<!-- Google analytics script-->
<script type="text/javascript">
  if(document.location.hostname == 'pratikborsadiya.in') {
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-72504830-1', 'auto');
    ga('send', 'pageview');
  }
</script>
</body>
</html>