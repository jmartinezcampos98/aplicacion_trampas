<?php

function abrir_conexion(): mysqli
{
    return new mysqli("localhost", "root", "", "trampas");
}
