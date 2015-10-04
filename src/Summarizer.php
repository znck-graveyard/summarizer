<?php namespace Znck\Summarizer;

/**
 * This file belongs to summarizer.
 *
 * Author: Rahul Kadyan, <hi@znck.me>
 * Find license in root directory of this project.
 */
use Html2Text\Html2Text;

/**
 * Class Summarizer
 *
 * @package Znck\Summarizer
 */
class Summarizer
{
    /**
     * @type string
     */
    protected $input;
    /**
     * @type string
     */
    protected $output;
    /**
     * @type int
     */
    protected $ratio = 20;
    /**
     * @type null|string
     */
    protected $dictionary;
    /**
     * @type string
     */
    protected $binary;

    /**
     * Summarizer constructor.
     *
     * @param int         $ratio
     * @param string|null $dictionary
     */
    public function __construct($ratio = 20, $dictionary = null)
    {
        $this->input = $this->getFilename();
        $this->output = $this->getFilename();
        $this->ratio = $ratio;
        $this->dictionary = $dictionary;
        $this->binary = "ots";
        if (!strlen(shell_exec("which {$this->binary}"))) {
            throw new \UnexpectedValueException('open text summarizer not available for this operation system.');
        }
    }

    /**
     * @param string $input Filename or url or content of the file.
     *                      File content should be at least 255 characters long.
     *
     * @param bool   $isFile
     *
     * @return string
     */
    public function summarize($input, $isFile = false)
    {
        $this->loadInput($input, $isFile);
        $parameters = $this->getParameters();
        exec($this->binary() . " {$parameters} --out={$this->output} {$this->input}");

        $output = file_get_contents($this->output);
        $this->clean();

        return $output;
    }

    /**
     * @param      $input
     * @param bool $isFile
     */
    protected function loadInput($input, $isFile = false)
    {
        if ($isFile) {
            $url = $input;
            $input = file_get_contents($url);
            if (strpos($url, 'http') == 0) {
                $input = (new Html2Text($input))->getText();
            }
        }
        $in = fopen($this->input, 'w');
        fwrite($in, $input);
        fclose($in);
    }

    /**
     * @return string
     */
    protected function getParameters()
    {
        $parameters = '';
        if (null !== $this->dictionary) {
            $parameters .= "--dict={$this->dictionary} ";
        }

        $parameters .= "--ratio={$this->ratio}";

        return $parameters;
    }

    /**
     * @return void
     */
    protected function clean()
    {
        file_put_contents($this->input, '');
        file_put_contents($this->output, '');
    }

    public function __destruct()
    {
        if (file_exists($this->input)) {
            unlink($this->input);
        }
        if (file_exists($this->output)) {
            unlink($this->output);
        }
    }

    /**
     * @return string
     */
    protected function getFilename()
    {
        return tempnam(sys_get_temp_dir(), $this->generateRandomString(16));
    }

    /**
     * @param int $length
     *
     * @return string
     */
    protected function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /**
     * @return string
     */
    protected function binary()
    {
        return $this->binary;
    }
}