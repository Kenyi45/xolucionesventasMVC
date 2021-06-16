$('#delete_crud').on('click', function (e) {
    e.preventDefault();

    const href =$(this).attr('href');
Swal.fire({
  title: 'Eliminar',
  text: "Estas seguro de eliminar este registro!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Sí, borrar!'
}).then((result) => {
  if (result.isConfirmed) {
    Swal.fire({
              icon: "success",
              title: "Eliminado",
              text:"Categoria eliminada correctamente",
              showConfirmButton: false,
              timer: 1500,
              position: 'center',
            })
      document.location.href = href;
  }
})
    
})