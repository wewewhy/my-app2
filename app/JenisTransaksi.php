<?php

namespace App;

enum JenisTransaksi: string
{
    case Debit = 'debit';
    case Kredit = 'kredit';
}
