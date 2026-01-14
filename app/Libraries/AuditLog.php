<?php

namespace App\Libraries;

/**
 * AuditLog
 *
 * Writes structured audit events to writable/logs/audit.log and the
 * standard CodeIgniter logger.
 */
class AuditLog
{
    private string $logFile;

    public function __construct(?string $logFile = null)
    {
        $this->logFile = $logFile ?? WRITEPATH . 'logs' . DIRECTORY_SEPARATOR . 'audit.log';
    }

    /**
     * Record an audit event.
     *
     * @param string $action Event name (e.g., auth.login.success)
     * @param array $context Additional context data
     * @param string $level Log level for log_message
     */
    public function log(string $action, array $context = [], string $level = 'info'): void
    {
        $request = service('request');
        $session = session();

        $payload = [
            'timestamp' => date('c'),
            'action' => $action,
            'user_id' => $session->get('user_id'),
            'user_email' => $session->get('user_email'),
            'ip' => $request->getIPAddress(),
            'method' => $request->getMethod(),
            'path' => $request->getPath(),
            'context' => $context,
        ];

        $line = json_encode($payload, JSON_UNESCAPED_SLASHES);

        $this->writeLine($line);
        log_message($level, 'audit {action}: {payload}', [
            'action' => $action,
            'payload' => $line,
        ]);
    }

    private function writeLine(string $line): void
    {
        $dir = dirname($this->logFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        file_put_contents($this->logFile, $line . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}
