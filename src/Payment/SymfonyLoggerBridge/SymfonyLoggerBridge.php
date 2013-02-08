<?php

namespace Payment\SymfonyLoggerBridge;

use Symfony\Component\HttpKernel\Log\LoggerInterface as SymfonyLoggerInterface;

use Psr\Log\LoggerInterface as PsrLoggerInterface;
use Psr\Log\AbstractLogger as PsrAbstractLogger;
use Psr\Log\LogLevel as PsrLogLevel;

use Psr\Log\InvalidArgumentException as PsrInvalidArgumentException;

class SymfonyLoggerBridge extends PsrAbstractLogger implements PsrLoggerInterface
{
    /**
     * @var SymfonyLoggerInterface
     */
    protected $symfonyLogger;

    /**
     * @param SymfonyLoggerInterface $symfonyLogger
     */
    public function __construct(SymfonyLoggerInterface $symfonyLogger)
    {
        $this->symfonyLogger = $symfonyLogger;

        if($symfonyLogger instanceof PsrLoggerInterface){
            $this->log(PsrLogLevel::INFO, sprintf(
                'Your class "%s" implements already the "%s" interface - Bridge is not necessary',
                get_class($symfonyLogger),
                "Psr\\Log\\LoggerInterface"
            ));
        }
    }

    /**
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     * @throws PsrInvalidArgumentException
     */
    public function log($level, $message, array $context = array())
    {
        switch($level){
            case PsrLogLevel::ALERT:
                $this->symfonyLogger->alert($message, $context);
                break;
            case PsrLogLevel::CRITICAL:
                $this->symfonyLogger->crit($message, $context);
                break;
            case PsrLogLevel::DEBUG:
                $this->symfonyLogger->debug($message, $context);
                break;
            case PsrLogLevel::EMERGENCY:
                $this->symfonyLogger->emerg($message, $context);
                break;
            case PsrLogLevel::ERROR:
                $this->symfonyLogger->err($message, $context);
                break;
            case PsrLogLevel::INFO:
                $this->symfonyLogger->info($message, $context);
                break;
            case PsrLogLevel::NOTICE:
                $this->symfonyLogger->notice($message, $context);
                break;
            case PsrLogLevel::WARNING:
                $this->symfonyLogger->warn($message, $context);
                break;
            default:
                throw new PsrInvalidArgumentException(sprintf('Loglevel "%s" not valid, use constants from "%s"', $level, "Psr\\Log\\LogLevel"));
                break;
        }

        return null;
    }
}