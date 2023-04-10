<?php

class ControladorLog
{
    const arquivoLog = "server-log-file.log";
    public function registraLog($evento, $horario)
    {        
        $text = $evento . " " . $horario . "\n";
        file_put_contents(self::arquivoLog, $text, FILE_APPEND);
    }
}
