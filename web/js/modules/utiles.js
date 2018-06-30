
function algoritmoModulo10(digitosIniciales, digitoVerificador)
{
    var arrayCoeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];

    digitoVerificador = parseInt(digitoVerificador);

    var total = 0;
    for (var key = 0; key < digitosIniciales.length; key++)
    {
        var valorPosicion = parseInt(digitosIniciales[key] * arrayCoeficientes[key]);
        if (valorPosicion >= 10)
        {
            var sum = 0;
            valorPosicion += '';
            for (var i = 0; i < valorPosicion.length; i++)
            {
                sum += parseInt(valorPosicion[i]);
            }
            valorPosicion = sum;
        }
        total += valorPosicion;
    }

    var residuo = total % 10;
    var resultado = 0;

    if (residuo == 0)
    {
        resultado = 0;
    }
    else
    {
        resultado = 10 - residuo;
    }

    if (resultado != digitoVerificador)
    {
        return 'D�gitos iniciales no validan contra D�gito Idenficador';
    }
    return true;
}


function validarInicial(numero, caracteres)
{
    if (numero == '')
    {
        return 'Valor no puede estar vacio';
    }

    if (isNaN(numero))
    {
        return 'Valor ingresado solo puede tener d�gitos';
    }

    if (numero.length != parseInt(caracteres))
    {
        return 'Valor ingresado debe tener ' + caracteres + ' caracteres';
    }

    return true;
}


function validarCodigoProvincia(numero)
{
    if (numero < 1 || numero > 24)
    {
        return false;//'C�digo de Provincia (dos primeros d�gitos) no deben estar entre 1 y 24';
    }
    return true;
}


function validarTercerDigito(numero, tipo)
{
    switch (tipo)
    {
        case 'cedula':
        case 'ruc_natural':
        {
            if (numero < 0 || numero > 5)
            {
                return 'Tercer d�gito debe ser mayor o igual a 0 y menor a 6 para c�dulas y RUC de persona natural';
            }
            break;
        }
        case 'ruc_privada':
        {
            if (numero != 9)
            {
                return 'Tercer d�gito debe ser igual a 9 para sociedades privadas';
            }
            break;
        }
        case 'ruc_publica':
        {
            if (numero != 6)
            {
                return 'Tercer d�gito debe ser igual a 6 para sociedades p�blicas';
            }
            break;
        }
        default:
        {
            return 'Tipo de Identificacion no existe.';
        }
    }
    return true;

}



function validarCedula(numero)
{
    var error = false;

    var text = numero + "";

    if ((error = validarCodigoProvincia(text.substr(0, 2))) != true)
    {
        return error;
    }

    return true;
}

function validarPlaca(placa)
{
    return /^[A-Za-z]{3}\-?\d{3,4}$/i.test(placa);
}



/**
 * Norma�I.S.O.�N��2716
 */
function validarContenedor(contenedor)
{
    if (preg_match('/^[A-Za-z]{4}\d{7}$/', contenedor) === 0)
    {
        return "El contenedor no cumple con el formato estableciodo. Deben ser 4 letras y 7 d�gitos";
    }
    var chars = contenedor;
    var suma = 0;
    for (var i = 0; i < chars.length - 1; i++)
    {
        var valorChar = chars[i];
        if (isNaN(valorChar))
        {
            valorChar = chars.charCodeAt(i) - 55;
        }
        suma += (valorChar * Math.pow(2, i));
    }
    var div = Math.floor(suma / 11);
    var mult = div * 11;
    if ((suma - mult) != chars[10])
    {
        return "Fallo en el c�digo de verificaci�n";
    }
    return true;
}
