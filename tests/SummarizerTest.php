<?php /**
 * This file belongs to summarizer.
 *
 * Author: Rahul Kadyan, <hi@znck.me>
 * Find license in root directory of this project.
 */
class SummarizerTest extends PHPUnit_Framework_TestCase
{
    protected $input = <<<'ARTICLE'
As per a recent study, micro photosynthetic power cells may be the green energy source for the next generation. Researchers from the Optical Bio Microsystem lab at Concordia University in Montreal, Canada, have invented and developed micro-photosynthetic cell technology that can harness electrical power from the photosynthesis and respiration of blue-green algae. This novel, scalable technology enables economical ways of generating clean energy, and may be the superlative, carbon-free power source for the future of mankind. The team headed by Muthukumaran Packirisamy has conceived and developed such a contraption. Clean and green carbon-free energy is globally anticipated as the potential soltution for the mitigation and eventual erasure of global warming. The main source of clean energy comes from the sun, which emits more energy to the earth every hour than mankind depletes in one year. Hence, technologies that derive energy from the sun are instrumental to the worldwide conversion of power sources to eco-friendly auxiliaries. This constitutes a large part of the incentive for the team, who has come up with an effective method for harnessing photosynthetic power from algae.
Both photosynthesis and respiration, which take place in plants cells, involve electron transfer chains. The main concept herein involves trapping these electrons that are released by blue-green algae. The electron transfer chains of photosynthesis and respiration are constructive in harnessing the electrical energy from blue-green algae. This photosynthetic power cell consists of an anode, cathode and proton exchange membrane. The anode chamber consists of cyanobacteria and it releases electrons to the electrode surface from a redox agent that is present at the cathode. An external load is connected to extract the electrons. The fabricated cell could produce an open circuit voltage of 993mV and a power density of 36.23W/cm2. The performance of the power cell can be increased by reducing the electrode spacing between the two electrodes of proton exchange membrane and efficient design of the cell. These micro photosynthetic power cells may entail significant military and wireless applications. They can also be good power sources for Bio MEMS devices. However, challenges still exists for MEMS researchers to fabricate the small scale anode-cathode chambers that are suitable for generating the high current density and high power density from the cell. The report is featured in the journal TECHNOLOGY.
ARTICLE;

    protected function summarizer($ratio = 0.25)
    {
        return new \Znck\Summarizer\Summarizer($ratio * 100);
    }

    public function test_with_string()
    {
        $input = $this->input;
        $output = $this->summarizer()->summarize($input, false);

        $ratio = strlen($output) * 1.0 / strlen($input);
        $this->assertEquals(0.25, $ratio, "Summarization ratio is {$ratio} but it should be 0.25", 0.1);
    }

    public function test_with_file()
    {
        file_put_contents(__DIR__ . '/input.txt', $this->input);
        $output = $this->summarizer()->summarize(__DIR__ . '/input.txt', true);

        $ratio = strlen($output) * 1.0 / strlen($this->input);
        $this->assertEquals(0.25, $ratio, "Summarization ratio is {$ratio} but it should be 0.25", 0.1);
        unlink(__DIR__ . '/input.txt');
    }

    public function test_with_link()
    {
        $input = file_get_contents('https://en.wikipedia.org/wiki/README');
        $output = $this->summarizer()->summarize('https://en.wikipedia.org/wiki/README', true);

        $ratio = strlen($output) * 1.0 / strlen($input);
        $this->assertLessThan(0.5, $ratio, "Summarization ratio is {$ratio} but it should be 0.25", 0.15);
    }

    public function test_ratio()
    {
        $input = $this->input;

        $output = $this->summarizer(0.1)->summarize($input, false);
        $ratio = strlen($output) * 1.0 / strlen($input);
        $this->assertEquals(0.1, $ratio, "Ratio should be 0.1 but it is {$ratio}.", 0.1);

        $output = $this->summarizer(0.2)->summarize($input, false);
        $ratio = strlen($output) * 1.0 / strlen($input);
        $this->assertEquals(0.2, $ratio, "Ratio should be 0.2 but it is {$ratio}.", 0.1);

        $output = $this->summarizer(0.3)->summarize($input, false);
        $ratio = strlen($output) * 1.0 / strlen($input);
        $this->assertEquals(0.3, $ratio, "Ratio should be 0.3 but it is {$ratio}.", 0.1);

        $output = $this->summarizer(0.4)->summarize($input, false);
        $ratio = strlen($output) * 1.0 / strlen($input);
        $this->assertEquals(0.4, $ratio, "Ratio should be 0.4 but it is {$ratio}.", 0.1);

        $output = $this->summarizer(0.5)->summarize($input, false);
        $ratio = strlen($output) * 1.0 / strlen($input);
        $this->assertEquals(0.5, $ratio, "Ratio should be 0.5 but it is {$ratio}.", 0.1);
    }
}
