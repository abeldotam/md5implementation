<?php
function implementMD5($string)
{
    //Variable initialisation
    $a = "67452301";
    $b = "efcdab89";
    $c = "98badcfe";
    $d = "10325476";

    $A = $a;
    $B = $b;
    $C = $c;
    $D = $d;

    //Conversion du message
    $compteurMot;
    $tailleMessage = strlen($string);
    $tempNombreMots_1 = $tailleMessage + 8;
    $tempNombreMots_2 = ($tempNombreMots_1 - ($tempNombreMots_1 % 64)) / 64;
    $nombreMots = ($tempNombreMots_2 + 1) * 16;
    $tableauMot = array("");
    $positionBit = 0;
    $compteurBit = 0;
    while ($compteurBit < $tailleMessage) {
        $compteurMot = ($compteurBit - ($compteurBit % 4)) / 4;
        $positionBit = ($compteurBit % 4) * 8;
        if (!isset($tableauMot[$compteurMot])) $tableauMot[$compteurMot] = 0;
        $tableauMot[$compteurMot] = ($tableauMot[$compteurMot] | (ord($string[$compteurBit]) << $positionBit));
        $compteurBit++;
    }
    $compteurMot = ($compteurBit - ($compteurBit % 4)) / 4;
    $positionBit = ($compteurBit % 4) * 8;
    if (!isset($tableauMot[$compteurMot])) $tableauMot[$compteurMot] = 0;
    $tableauMot[$compteurMot] = $tableauMot[$compteurMot] | (0x80 << $positionBit);
    $tableauMot[$nombreMots - 2] = $tailleMessage << 3;
    $tableauMot[$nombreMots - 1] = $tailleMessage >> 29;
    for ($i = 0; $i < $nombreMots; $i++) {
        if (isset($tableauMot[$i])) $tableauMot[$i] = decbin($tableauMot[$i]);
        else $tableauMot[$i] = '0';
    }
    $mots = $tableauMot;

    //Calcul processing
    for ($i = 0; $i <= count($mots) / 16 - 1; $i++) {
        $a = $A;
        $b = $B;
        $c = $C;
        $d = $D;

        /* ROUND 1 */
        FF($A, $B, $C, $D, $mots[0 + ($i * 16)], 7, "d76aa478");
        FF($D, $A, $B, $C, $mots[1 + ($i * 16)], 12, "e8c7b756");
        FF($C, $D, $A, $B, $mots[2 + ($i * 16)], 17, "242070db");
        FF($B, $C, $D, $A, $mots[3 + ($i * 16)], 22, "c1bdceee");
        FF($A, $B, $C, $D, $mots[4 + ($i * 16)], 7, "f57c0faf");
        FF($D, $A, $B, $C, $mots[5 + ($i * 16)], 12, "4787c62a");
        FF($C, $D, $A, $B, $mots[6 + ($i * 16)], 17, "a8304613");
        FF($B, $C, $D, $A, $mots[7 + ($i * 16)], 22, "fd469501");
        FF($A, $B, $C, $D, $mots[8 + ($i * 16)], 7, "698098d8");
        FF($D, $A, $B, $C, $mots[9 + ($i * 16)], 12, "8b44f7af");
        FF($C, $D, $A, $B, $mots[10 + ($i * 16)], 17, "ffff5bb1");
        FF($B, $C, $D, $A, $mots[11 + ($i * 16)], 22, "895cd7be");
        FF($A, $B, $C, $D, $mots[12 + ($i * 16)], 7, "6b901122");
        FF($D, $A, $B, $C, $mots[13 + ($i * 16)], 12, "fd987193");
        FF($C, $D, $A, $B, $mots[14 + ($i * 16)], 17, "a679438e");
        FF($B, $C, $D, $A, $mots[15 + ($i * 16)], 22, "49b40821");

        /* ROUND 2 */
        GG($A, $B, $C, $D, $mots[1 + ($i * 16)], 5, "f61e2562");
        GG($D, $A, $B, $C, $mots[6 + ($i * 16)], 9, "c040b340");
        GG($C, $D, $A, $B, $mots[11 + ($i * 16)], 14, "265e5a51");
        GG($B, $C, $D, $A, $mots[0 + ($i * 16)], 20, "e9b6c7aa");
        GG($A, $B, $C, $D, $mots[5 + ($i * 16)], 5, "d62f105d");
        GG($D, $A, $B, $C, $mots[10 + ($i * 16)], 9, "2441453");
        GG($C, $D, $A, $B, $mots[15 + ($i * 16)], 14, "d8a1e681");
        GG($B, $C, $D, $A, $mots[4 + ($i * 16)], 20, "e7d3fbc8");
        GG($A, $B, $C, $D, $mots[9 + ($i * 16)], 5, "21e1cde6");
        GG($D, $A, $B, $C, $mots[14 + ($i * 16)], 9, "c33707d6");
        GG($C, $D, $A, $B, $mots[3 + ($i * 16)], 14, "f4d50d87");
        GG($B, $C, $D, $A, $mots[8 + ($i * 16)], 20, "455a14ed");
        GG($A, $B, $C, $D, $mots[13 + ($i * 16)], 5, "a9e3e905");
        GG($D, $A, $B, $C, $mots[2 + ($i * 16)], 9, "fcefa3f8");
        GG($C, $D, $A, $B, $mots[7 + ($i * 16)], 14, "676f02d9");
        GG($B, $C, $D, $A, $mots[12 + ($i * 16)], 20, "8d2a4c8a");

        /* ROUND 3 */
        HH($A, $B, $C, $D, $mots[5 + ($i * 16)], 4, "fffa3942");
        HH($D, $A, $B, $C, $mots[8 + ($i * 16)], 11, "8771f681");
        HH($C, $D, $A, $B, $mots[11 + ($i * 16)], 16, "6d9d6122");
        HH($B, $C, $D, $A, $mots[14 + ($i * 16)], 23, "fde5380c");
        HH($A, $B, $C, $D, $mots[1 + ($i * 16)], 4, "a4beea44");
        HH($D, $A, $B, $C, $mots[4 + ($i * 16)], 11, "4bdecfa9");
        HH($C, $D, $A, $B, $mots[7 + ($i * 16)], 16, "f6bb4b60");
        HH($B, $C, $D, $A, $mots[10 + ($i * 16)], 23, "bebfbc70");
        HH($A, $B, $C, $D, $mots[13 + ($i * 16)], 4, "289b7ec6");
        HH($D, $A, $B, $C, $mots[0 + ($i * 16)], 11, "eaa127fa");
        HH($C, $D, $A, $B, $mots[3 + ($i * 16)], 16, "d4ef3085");
        HH($B, $C, $D, $A, $mots[6 + ($i * 16)], 23, "4881d05");
        HH($A, $B, $C, $D, $mots[9 + ($i * 16)], 4, "d9d4d039");
        HH($D, $A, $B, $C, $mots[12 + ($i * 16)], 11, "e6db99e5");
        HH($C, $D, $A, $B, $mots[15 + ($i * 16)], 16, "1fa27cf8");
        HH($B, $C, $D, $A, $mots[2 + ($i * 16)], 23, "c4ac5665");

        /* ROUND 4 */
        II($A, $B, $C, $D, $mots[0 + ($i * 16)], 6, "f4292244");
        II($D, $A, $B, $C, $mots[7 + ($i * 16)], 10, "432aff97");
        II($C, $D, $A, $B, $mots[14 + ($i * 16)], 15, "ab9423a7");
        II($B, $C, $D, $A, $mots[5 + ($i * 16)], 21, "fc93a039");
        II($A, $B, $C, $D, $mots[12 + ($i * 16)], 6, "655b59c3");
        II($D, $A, $B, $C, $mots[3 + ($i * 16)], 10, "8f0ccc92");
        II($C, $D, $A, $B, $mots[10 + ($i * 16)], 15, "ffeff47d");
        II($B, $C, $D, $A, $mots[1 + ($i * 16)], 21, "85845dd1");
        II($A, $B, $C, $D, $mots[8 + ($i * 16)], 6, "6fa87e4f");
        II($D, $A, $B, $C, $mots[15 + ($i * 16)], 10, "fe2ce6e0");
        II($C, $D, $A, $B, $mots[6 + ($i * 16)], 15, "a3014314");
        II($B, $C, $D, $A, $mots[13 + ($i * 16)], 21, "4e0811a1");
        II($A, $B, $C, $D, $mots[4 + ($i * 16)], 6, "f7537e82");
        II($D, $A, $B, $C, $mots[11 + ($i * 16)], 10, "bd3af235");
        II($C, $D, $A, $B, $mots[2 + ($i * 16)], 15, "2ad7d2bb");
        II($B, $C, $D, $A, $mots[9 + ($i * 16)], 21, "eb86d391");

        $A = ajoutHex(hexdec2($A), hexdec2($a));
        $B = ajoutHex(hexdec2($B), hexdec2($b));
        $C = ajoutHex(hexdec2($C), hexdec2($c));
        $D = ajoutHex(hexdec2($D), hexdec2($d));
    }

    /* FINAL STEP */
    $temp = "";
    for ($compteur = 0; $compteur <= 3; $compteur++) {
        $lByte = (hexdec2($A) >> ($compteur * 8)) & 255;
        $E = dechex($lByte);
        $temp .= (strlen($E) == '1') ? "0" . dechex($lByte) : dechex($lByte);
    }
    $A = $temp;

    $temp = "";
    for ($compteur = 0; $compteur <= 3; $compteur++) {
        $lByte = (hexdec2($B) >> ($compteur * 8)) & 255;
        $E = dechex($lByte);
        $temp .= (strlen($E) == '1') ? "0" . dechex($lByte) : dechex($lByte);
    }
    $B = $temp;

    $temp = "";
    for ($compteur = 0; $compteur <= 3; $compteur++) {
        $lByte = (hexdec2($C) >> ($compteur * 8)) & 255;
        $E = dechex($lByte);
        $temp .= (strlen($E) == '1') ? "0" . dechex($lByte) : dechex($lByte);
    }
    $C = $temp;

    $temp = "";
    for ($compteur = 0; $compteur <= 3; $compteur++) {
        $lByte = (hexdec2($D) >> ($compteur * 8)) & 255;
        $E = dechex($lByte);
        $temp .= (strlen($E) == '1') ? "0" . dechex($lByte) : dechex($lByte);
    }
    $D = $temp;



    $MD5 = $A . $B . $C . $D;
    return $MD5;
}

function F($X, $Y, $Z)
{
    $X = hexdec2($X);
    $Y = hexdec2($Y);
    $Z = hexdec2($Z);
    $calc = (($X & $Y) | ((~$X) & $Z)); // X AND Y OR NOT X AND Z
    return  $calc;
}

function G($X, $Y, $Z)
{
    $X = hexdec2($X);
    $Y = hexdec2($Y);
    $Z = hexdec2($Z);
    $calc = (($X & $Z) | ($Y & (~$Z))); // X AND Z OR Y AND NOT Z
    return  $calc;
}

function H($X, $Y, $Z)
{
    $X = hexdec2($X);
    $Y = hexdec2($Y);
    $Z = hexdec2($Z);
    $calc = ($X ^ $Y ^ $Z); // X XOR Y XOR Z
    return  $calc;
}

function I($X, $Y, $Z)
{
    $X = hexdec2($X);
    $Y = hexdec2($Y);
    $Z = hexdec2($Z);
    $calc = ($Y ^ ($X | (~$Z))); // Y XOR (X OR NOT Z)
    return  $calc;
}

function ajoutHex($lX, $lY)
{
    $X8 = ($lX & 0x80000000);
    $Y8 = ($lY & 0x80000000);
    $lX4 = ($lX & 0x40000000);
    $lY4 = ($lY & 0x40000000);
    $resultat = ($lX & 0x3FFFFFFF) + ($lY & 0x3FFFFFFF);
    if ($lX4 & $lY4) {
        $res = ($resultat ^ 0x80000000 ^ $X8 ^ $Y8);
        if ($res < 0) return '-' . dechex(abs($res));
        else return dechex($res);
    }
    if ($lX4 | $lY4) {
        if ($resultat & 0x40000000) {
            $res = ($resultat ^ 0xC0000000 ^ $X8 ^ $Y8);
            if ($res < 0) return '-' . dechex(abs($res));
            else return dechex($res);
        } else {
            $res = ($resultat ^ 0x40000000 ^ $X8 ^ $Y8);
            if ($res < 0) return '-' . dechex(abs($res));
            else return dechex($res);
        }
    } else {
        $res = ($resultat ^ $X8 ^ $Y8);
        if ($res < 0)
            return '-' . dechex(abs($res));
        else
            return dechex($res);
    }
}
function hexdec2($hex, $debug = false)
{
    if (substr($hex, 0, 1) == "-") {
        return doubleval('-' . hexdec("0x" . str_replace("-", "", $hex)));
    }
    return hexdec("0x" . $hex);
}

function FF(&$A, $B, $C, $D, $M, $s, $t)
{
    $niveau1 = hexdec2(ajoutHex(F($B, $C, $D), bindec($M)));
    $niveau2 = hexdec2(ajoutHex($niveau1, hexdec2($t)));
    $A = hexdec2(ajoutHex(hexdec2($A), $niveau2));
    $A = (($A << $s) |  decalageDroite($A, (32 - $s))  & 0xffffffff); //Rotate 
    $A =  ajoutHex($A, hexdec2($B));
}

function GG(&$A, $B, $C, $D, $M, $s, $t)
{
    $niveau1 = hexdec2(ajoutHex(G($B, $C, $D), bindec($M)));
    $niveau2 = hexdec2(ajoutHex($niveau1, hexdec2($t)));
    $A = hexdec2(ajoutHex(hexdec2($A), $niveau2));
    $A = (($A << $s) |  decalageDroite($A, (32 - $s))  & 0xffffffff); //Rotate 
    $A =  ajoutHex($A, hexdec2($B));
}

function HH(&$A, $B, $C, $D, $M, $s, $t)
{
    $niveau1 = hexdec2(ajoutHex(H($B, $C, $D), bindec($M)));
    $niveau2 = hexdec2(ajoutHex($niveau1, hexdec2($t)));
    $A = hexdec2(ajoutHex(hexdec2($A), $niveau2));
    $A = (($A << $s) |  decalageDroite($A, (32 - $s))  & 0xffffffff); //Rotate
    $A =  ajoutHex($A, hexdec2($B));
}

function II(&$A, $B, $C, $D, $M, $s, $t)
{
    $niveau1 = hexdec2(ajoutHex(I($B, $C, $D), bindec($M)));
    $niveau2 = hexdec2(ajoutHex($niveau1, hexdec2($t)));
    $A = hexdec2(ajoutHex(hexdec2($A), $niveau2));
    $A = (($A << $s) |  decalageDroite($A, (32 - $s))  & 0xffffffff); //Rotate
    $A =  ajoutHex($A, hexdec2($B));
}


function decalageDroite($decimale, $droite)
{
    if ($decimale < 0) {
        $res = decbin($decimale >> $droite);
        for ($i = 0; $i < $droite; $i++) {
            $res[$i] = "";
        }
        return bindec($res);
    } else {
        return ($decimale >> $droite);
    }
}
