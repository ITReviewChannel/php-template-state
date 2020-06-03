<?php

namespace ITReviewChannel;

/**
 * Состояние.
 */
abstract class State
{
    /**
     * @var TrafficLight $trafficLight Светофор.
     */
    protected TrafficLight $trafficLight;

    /**
     * Конструктор.
     *
     * @param  TrafficLight  $trafficLight  Светофор.
     */
    public function __construct(TrafficLight $trafficLight)
    {
        $this->trafficLight = $trafficLight;
    }

    /**
     * Срабатывание.
     */
    abstract public function work(): void;
}

/**
 * Состояние "Предупреждение".
 */
final class StateWarning extends State
{
    /**
     * {@inheritDoc}
     */
    public function work(): void
    {
        sleep(1);

        echo 'ПРЕДУПРЕЖДЕНИЕ (ЖЕЛТЫЙ)' . PHP_EOL;

        if ($this->trafficLight->isPreviousStateGo()) {
            $this->trafficLight->switchToStateStop();
        } else {
            $this->trafficLight->switchToStateGo();
        }
    }
}

/**
 * Состояние "Стоп".
 */
final class StateStop extends State
{
    /**
     * {@inheritDoc}
     */
    public function work(): void
    {
        sleep(1);

        echo 'СТОП (КРАСНЫЙ)' . PHP_EOL;

        $this->trafficLight->switchToStateWarning();
    }
}

/**
 * Состояние "Движение".
 */
final class StateGo extends State
{
    /**
     * {@inheritDoc}
     */
    public function work(): void
    {
        sleep(1);

        echo 'ДВИЖЕНИЕ (ЗЕЛЕНЫЙ)' . PHP_EOL;

        $this->trafficLight->switchToStateWarning();
    }
}

/**
 * Светофор.
 *
 * ПРЕДУПРЕЖДЕНИЕ (ЖЕЛТЫЙ) - СТОП (КРАСНЫЙ) - ПРЕДУПРЕЖДЕНИЕ (ЖЕЛТЫЙ) - ДВИЖЕНИЕ (ЗЕЛЕНЫЙ)
 */
final class TrafficLight
{
    /**
     * @var State Состояние "Предупреждение".
     */
    private State $stateWarning;
    /**
     * @var State Состояние "Стоп".
     */
    private State $stateStop;
    /**
     * @var State Состояние "Движение".
     */
    private State $stateGo;

    /**
     * @var State $state Состояние.
     */
    private State $state;
    /**
     * @var State $previousState Предыдущее состояние.
     */
    private State $previousState;

    /**
     * Конструктор.
     */
    public function __construct()
    {
        $this->stateWarning = new StateWarning($this);
        $this->stateStop = new StateStop($this);
        $this->stateGo = new StateGo($this);

        $this->state = $this->stateWarning;
        $this->previousState = $this->stateStop;
    }

    /**
     * Срабатывание.
     */
    public function work(): void
    {
        $this->state->work();
    }

    /**
     * Переключение в состояние "Движение".
     */
    public function switchToStateGo(): void
    {
        $this->state = $this->stateGo;
    }

    /**
     * Переключение в состояние "Стоп".
     */
    public function switchToStateStop(): void
    {
        $this->state = $this->stateStop;
    }

    /**
     * Переключение в состояние "Предупреждение".
     */
    public function switchToStateWarning(): void
    {
        $this->previousState = $this->state;

        $this->state = $this->stateWarning;
    }

    /**
     * Является ли предыдущее состояние "ДВИЖЕНИЕМ".
     *
     * @return bool
     */
    public function isPreviousStateGo(): bool
    {
        return $this->previousState === $this->stateGo;
    }
}

$trafficLight = new TrafficLight();

$trafficLight->work();
$trafficLight->work();
$trafficLight->work();
$trafficLight->work();
$trafficLight->work();
$trafficLight->work();
$trafficLight->work();
$trafficLight->work();
