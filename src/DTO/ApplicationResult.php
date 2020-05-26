<?php
namespace App\DTO;

/**
 * DTO с результатами добавления заявки.
 */
class ApplicationResult
{
    /** Статус добавления. */
    private bool $success;

    /** Причина ошибки. */
    private string $reason;

    /**
     * Конструктор.
     *
     * @param bool $success
     * @param string $reason
     */
    public function __construct(bool $success, string $reason)
    {
        $this->success = $success;
        $this->reason = $reason;
    }

    /**
     * Получить статус добавления.
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * Установить статус добавления.
     *
     * @param bool $success
     */
    public function setSuccess(bool $success): void
    {
        $this->success = $success;
    }

    /**
     * Получить причину.
     *
     * @return string
     */
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * Установить причину.
     *
     * @param string $reason
     */
    public function setReason(string $reason): void
    {
        $this->reason = $reason;
    }
}
