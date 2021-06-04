const Toast = Swal.mixin({
    toast: true,
    position: 'top-right',
    iconColor: 'green',
    customClass: {
        popup: 'colored-toast'
    },
    showConfirmButton: false,
    timer: 1500,
    timerProgressBar: true
});
export default {
    data: () => ({
        data: '',
    }),
    methods: {
        notify(message) {
           Toast.fire({
                icon: message.type,
                title: message.text,
            })
        },
        notifyError(message) {
            Toast.fire({
                icon: "danger",
                title: message.text
            })
        }
    }
}
