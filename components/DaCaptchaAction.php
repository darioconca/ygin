<?php
class DaCaptchaAction extends CCaptchaAction {
	
	private $_letters = '1234567890';

	/**
	 * @param $string
	 */
	public function setLetters($string) {
		$this->_letters = $string;
	}

	const LENGTH_MIN = 3;
	const LENGTH_MAX = 20;

	/**
	 * Generates a new verification code.
	 * @return string the generated verification code
	 */
	protected function generateVerifyCode() {
		if ($this->minLength < self::LENGTH_MIN) {
			$this->minLength = self::LENGTH_MIN;
		}
		if ($this->maxLength > self::LENGTH_MAX) {
			$this->maxLength = self::LENGTH_MAX;
		}
		if ($this->minLength > $this->maxLength){
			$this->maxLength = $this->minLength;
		}
		
		$length = rand($this->minLength,$this->maxLength);

		// Тут указываем символы которые будут
		// выводится у нас на капче.
		$code = '';
		for($i = 0; $i < $length; $i++) {
			$code .= $this->_letters[rand(0, strlen($this->_letters)-1)];
		}
		return $code;
	}
}
