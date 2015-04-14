<?php

namespace PHPixie\Tests\HTTP\Messages;

/**
 * @coversDefaultClass PHPixie\HTTP\Messages\UploadedFile
 */
abstract class UploadedFileTest extends \PHPixie\Test\Testcase
{
    protected $messages;
    
    protected $uploadedFile;
    
    protected $clientFilename  = 'Pixie.png';
    protected $clientMediaType = 'image/png';
    protected $file            = 'fairy.png';
    protected $error           = 0;
    protected $size            = 300;
    
    public function setUp()
    {
        $this->messages = $this->quickMock('\PHPixie\HTTP\Messages');
        
        $this->uploadedFile = $this->uploadedFile();
    }
    
    /**
     * @covers \PHPixie\HTTP\Messages\UploadedFile::__construct
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
    
    }
    
    /**
     * @covers ::getStream
     * @covers ::<protected>
     */
    public function testGetStream()
    {
        $stream = $this->abstractMock('\Psr\Http\Message\StreamInterface');
        $this->method($this->messages, 'stream', $stream, array($this->file), 0);
        for($i=0; $i<2; $i++) {
            $this->assertSame($stream, $this->uploadedFile->getStream());
        }
    }

    /**
     * @covers ::getClientFilename
     * @covers ::getClientMediaType
     * @covers ::getError
     * @covers ::getSize
     * @covers ::<protected>
     */
    public function testGetters()
    {
        $getters = array(
            'clientFilename',
            'clientMediaType',
            'error',
            'size'
        );
        
        foreach($getters as $name) {
            $method = 'get'.ucfirst($name);
            $this->assertSame($this->$name, $this->uploadedFile->$method());
        }
    }
    
    /**
     * @covers ::getStream
     * @covers ::move
     * @covers ::<protected>
     */
    public function testInvalidUpload()
    {
        $this->error = 1;
        $uploadedFile = $this->uploadedFile();
        
        $this->assertException(function() use($uploadedFile) {
            $uploadedFile->getStream();
        }, '\RuntimeException');
        
        $this->assertException(function() use($uploadedFile) {
            $uploadedFile->move('test');
        }, '\RuntimeException');
    }
    
    protected abstract function uploadedFile();
}