var table = $('#datatable').DataTable({
    "searching": true,
    "ordering": true,
    "lengthMenu": [25, 50, 75, 100],
    "pageLength": 25,
    "bInfo": true,
    "responsive": true,
    "dom": 'lfBrtip',
    "buttons": [
        'copy', 'excel','csv'
    ],
    language: {
        'search': '',
        'searchPlaceholder': 'بحث',
        "paginate": {
            "previous": "السابق",
            'next': 'التالي',
            'first': 'الأولى',
            'last': 'الأخيرة',
        },
        info: 'الصفحة _PAGE_ من _PAGES_',
        infoEmpty: 'لا يوجد بيانات متوفرة',
        infoFiltered: '(نتائج من _MAX_ مجموع النتائج)',
        lengthMenu: 'عرض _MENU_ من البيانات في الصفحة',
        zeroRecords: 'لا نتائج'
    }
});

table.buttons().container()
    .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );    

