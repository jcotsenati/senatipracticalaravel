export function bootbox_prompt(mensaje){

    return new Promise((resolve, reject) => {

        window.bootbox.prompt(mensaje, function(result){
            resolve(result);
        });
          
    });
}////////////////////////////////////////////////////////
export function bootbox_alert(mensaje){

    return new Promise((resolve, reject) => {

        window.bootbox.alert(mensaje, function(){
            resolve("");
        });
          
    });
}////////////////////////////////////////////////////////
export function bootbox_confirm(mensaje){

    return new Promise((resolve, reject) => {

        window.bootbox.confirm({
            message: mensaje,
            buttons: {
            confirm: {
            label: 'Si',
            className: 'btn-success'
            },
            cancel: {
            label: 'No',
            className: 'btn-danger'
            }
            },
            callback: function (result) {

                resolve(result);
            }
        });
    
    });
}////////////////////////////////////////////////////////