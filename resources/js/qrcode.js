
window.onload = () => {

    const url = document.getElementById('url').value;
    const div = document.getElementById('qrcode');

    var qrcode = new QRCode(div,{
        text: url,
        width: 200,
        height: 200,
        colorDark: 'black',
        colorLight: 'white',
        correctLevel: QRCode.CorrectLevel.H
    });

}

