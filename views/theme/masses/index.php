<?php $v->layout("theme/layout"); ?>

<!-- Button -->
<div class="d-flex">
  <a class="btn btn-primary btn-round ml-auto mb-3" href="<?= $router->route("masses.new"); ?>">
    <i class="fa fa-plus"></i>
    Adicionar
  </a>
</div>

<div class="table-responsive">
  <table id="datatablesListMass" class="display table table-striped table-hover" cellspacing="0" width="100%">
    <thead>
          <tr>
            <th>Id</th>
            <th>Data</th>
            <th>Horas</th>
            <th>Info</th>
            <th>Intenção</th>
            <th>Fiel</th>
            <th>Ação</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Id</th>
            <th>Data</th>
            <th>Horas</th>
            <th>Info</th>
            <th>Intenção</th>
            <th>Fiel</th>
            <th>Ação</th>
          </tr>
        </tfoot>
  </table>
</div>


<!-- Modal -->
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="modalConfirmDeleteFaithful" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><b>Confirma Exclusão</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Deseja excluir o pedido de: <b><span id="massFaithful">_____</span></b>?
        <p></p>
        <div class="alert alert-danger" role="alert">
          Esse valor será retirado do caixa!
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <a id="buttonDelete" class="btn btn-primary" href="">Excluir</a>
      </div>
    </div>
  </div>
</div>

<?php $v->start("scripts"); ?>
<script>
  function deleteMass(id) {
    var faithful = $("#faithful_" + id).html();
    var date = $("#date_" + id).html();

    $("#massFaithful").html(faithful + ' em ' + date);
    $('#confirmDelete').modal();
    $('#buttonDelete').attr('href', '<?= $router->route("masses.delete", ["id_mass" => ""]) ?>' + id);
  }

  $(document).ready(function() {
    $('#buttonMenu').trigger('click');

    $('#datatablesListMass').dataTable({
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json",
      },
      "pageLength": 30,
      processing: true,
      serverSide: true,
      ajax: '<?= $router->route("masses.ajaxListMasses") ?>',
      columnDefs: [
        {
          render: function (data, type, row) {
            return data + ' - ' + row[2];
          },
          targets: 1,
        },
        {
          render: function (data, type, row) {
            return `
              <button class="badge badge-info" data-toggle="popover" data-container="body" data-placement="top" data-content="`+row[3]+`" data-original-title="Missa">
                Info
              </button>`+ data
          },
          targets: 4,
        },
        {
          targets: 1,
          createdCell: function (td, cellData, rowData, row, col) {
            $(td).attr('id', 'date_'+rowData[0]).attr('style', 'white-space: nowrap')
          }
        },
        {
          targets: 5,
          createdCell: function (td, cellData, rowData, row, col) {
            $(td).attr('id', 'faithful_'+rowData[0])
          }
        },
        { visible: false, targets: [ 2, 3] },
      ],
      initComplete: function() {
        this.api().columns().every(function() {
          var column = this;
          var select = $('<select class="form-control"><option value=""></option></select>')
            .appendTo($(column.footer()).empty())
            .on('change', function() {
              var val = $.fn.dataTable.util.escapeRegex(
                $(this).val()
              );

              column
                .search(val ? '^' + val + '$' : '', true, false)
                .draw();
            });

          column.data().unique().sort().each(function(d, j) {
            select.append('<option value="' + d + '">' + d + '</option>')
          });
        });
      },
      fnDrawCallback: function() {
        $('[data-toggle="popover"]').popover();
      }
    });
  });
</script>
<?php $v->end(); ?>             