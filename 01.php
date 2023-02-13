<?php

interface Vehicle {
	public function run(int $speed);
	public function consumeFuel(int $amount);
	public function addFuel(int $amount);

}

interface Cost {
	public function payFuelFee(int $fee);
	public function payTax(int $tax);
}

interface HighwayAvailable {
	public function runInHigherSpeed(int $speed);
}

interface NeedHelmet {
	public function riderWearHelmet(bool $wear);
	public function passengerWearHelmet(bool $wear);
}

abstract class VehicleOnGround implements Vehicle, Cost {

	public $fuel = 100;
	public $cost = 0;

	protected $errorMessages = [];

	protected function checkFuel(int $consumeFuelAmount) {
		if ($this->fuel < $consumeFuelAmount) {
			array_push($this->errorMessages, 'Please add Fuel' . "\r\n");
		}
	}
	protected function checkMaxSpeed(int $speed, int $speedLimit) {
		if ($speed > $speedLimit) {
			array_push($this->errorMessages, 'Too Fast.' . "\r\n");
		}
	}
	protected function printErrorMessages() {
		foreach ($this->errorMessages as $message) {
			echo $message;
		}
	}

	public function addFuel(int $amount) {
		$this->fuel += $amount;
		echo 'Adding fuel, left fuel: ' . $this->fuel . "\r\n";
		$this->payFuelFee($amount * 10);
		return $this;
	}
	public function consumeFuel(int $amount) {
		$this->fuel -= $amount;
		echo 'Consuming fuel, left fuel: ' . $this->fuel . "\r\n";
		return $this;
	}

	public function payFuelFee(int $fee) {
		$this->cost += $fee;
		echo 'Paying fuel fee, Total cost: ' . $this->cost . "\r\n";
		return $this;
	}

	public function payTax(int $tax) {
		$this->cost += $tax;
		echo 'Paying tax, Total cost: ' . $this->cost . "\r\n";
		return $this;
	}

}

abstract class Car extends VehicleOnGround implements HighwayAvailable {
	protected $driver = false;
	protected $passengers = 0;

	public function driverOnCar(bool $on) {
		$this->driver = $on;
		return $this;
	}
	public function passengersOnCar(int $number) {
		$this->passengers = $number;
		return $this;
	}

	protected function checkDriver() {
		if (!$this->driver) {
			array_push($this->errorMessages, 'No Driver.' . "\r\n");
		}
	}

	protected function checkMinSpeed(int $speed, int $speedLimit) {
		if ($speed < $speedLimit) {
			array_push($this->errorMessages, 'Too Slow.' . "\r\n");

		}
	}

}

abstract class Motorcycle extends VehicleOnGround implements NeedHelmet {
	protected $rider = false;
	protected $passenger = false;
	protected $riderHelmet = false;
	protected $passengerHelmet = false;

	public function riderWearHelmet(bool $wear) {
		$this->riderHelmet = $wear;
		return $this;
	}

	public function passengerWearHelmet(bool $wear) {
		if (!$this->passenger) {
			echo 'No Passenger, failed wearing helmet.' . "\r\n";
		} else {
			$this->passengerHelmet = $wear;
		}
		return $this;
	}

	public function riderOnMotorcycle(bool $on) {
		$this->rider = $on;
		return $this;
	}

	public function passengerOnMotorcycle(bool $on) {
		$this->passenger = $on;
		return $this;
	}

	protected function checkRider() {
		if (!$this->rider) {
			array_push($this->errorMessages, 'No Rider.' . "\r\n");
		} elseif (!$this->riderHelmet) {
			array_push($this->errorMessages, 'Rider no helmet.' . "\r\n");
		}

	}
	protected function checkPassenger() {
		if ($this->passenger && !$this->passengerHelmet) {
			array_push($this->errorMessages, 'Passenger no helmet.' . "\r\n");
		}
	}

}

class Sedan extends Car {

	public function __construct(bool $driverOn = true) {
		$this->driver = $driverOn;
		return $this;
	}

	protected function runCheck(string $runType = "default", int $speed, $consumeFuelAmount) {
		$this->errorMessages = [];
		if ($runType == "default") {
			$this->checkMaxSpeed($speed, 80);
		} else {
			$this->checkMinSpeed($speed, 80);
		}
		$this->checkDriver();
		$this->checkFuel($consumeFuelAmount);
	}

	public function run($speed = 50) {

		$consumeFuelAmount = intdiv($speed, 3);
		$this->runCheck("default", $speed, $consumeFuelAmount);

		if (!$this->errorMessages) {
			echo 'This is a sedan run in ' . $speed . 'km/h with ' . $this->passengers . ' passengers.';
			$this->consumeFuel($consumeFuelAmount);
		} else {
			$this->printErrorMessages();
		}
		return $this;
	}

	public function runInHigherSpeed(int $speed = 100) {

		$consumeFuelAmount = intdiv($speed, 4);
		$this->runCheck("highway", $speed, $consumeFuelAmount);

		if (!$this->errorMessages) {
			echo 'This is a sedan run in a highway (speed:' . $speed . 'km/h) with ' . $this->passengers . ' passengers.' . "\r\n";
			$this->consumeFuel($consumeFuelAmount);
		} else {
			$this->printErrorMessages();
		}
		return $this;

	}

}

class Scooter extends Motorcycle {

	public function __construct(bool $riderOn = true, bool $riderWearHelmet = true) {
		$this->rider = $riderOn;
		$this->riderHelmet = $riderWearHelmet;
	}

	protected function runCheck(int $speed, $consumeFuelAmount) {
		$this->errorMessages = [];
		$this->checkRider();
		$this->checkPassenger();
		$this->checkMaxSpeed($speed, 80);
	}

	public function run(int $speed = 50) {

		$consumeFuelAmount = intdiv($speed, 3);
		$this->runCheck($speed, $consumeFuelAmount);

		if (!$this->errorMessages) {
			if ($this->passenger) {
				echo 'This is a scooter run in ' . $speed . 'km/h.' . "\r\n";
			} else {
				echo 'This is a scooter run in ' . $speed . 'km/h with 1 passenger.' . "\r\n";
			}
			$this->consumeFuel($consumeFuelAmount);
		} else {
			$this->printErrorMessages();
		}
		return $this;
	}
}

## TEST ##
$scooterA = new Scooter();
$scooterA->run()->run()->run()->addFuel(100)->passengerOnMotorcycle(true)->run()->passengerWearHelmet(true)->run(100)->run(50);
$scooterA->run()->addFuel(30)->run();

$sedanB = new Sedan(false);
$sedanB->run();
$sedanB->driverOnCar(true)->run();
$sedanB->run(90)->runInHigherSpeed(60)->runInHigherSpeed()->passengersOnCar(3)->run();