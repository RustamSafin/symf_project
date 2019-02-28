<?php

namespace AppBundle\Sonata;

use Sonata\MediaBundle\Model\Media;
use Sonata\MediaBundle\Provider\BaseProvider;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\MediaBundle\Model\MediaInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\Response;

class SoundCloudProvider
{


    /**
     * return the reference image of the media, can be the video thumbnail or the original uploaded picture.
     *
     * @param MediaInterface $media
     *
     * @return string to the reference image
     */
    public function getReferenceImage(MediaInterface $media)
    {
        return $media->getMetadataValue('thumbnail_url');
    }

    /**
     * @param MediaInterface $media
     */
    public function postUpdate(MediaInterface $media)
    {
        $this->postPersist($media);
    }

    /**
     * build the related create form.
     *
     * @param FormMapper $formMapper
     */
    public function buildCreateForm(FormMapper $formMapper)
    {
        $formMapper->add('binaryContent', array(), array('type' => 'string'));
    }

    /**
     * build the related create form.
     *
     * @param FormMapper $formMapper
     */
    public function buildEditForm(FormMapper $formMapper)
    {
        $formMapper->add('name');
        $formMapper->add('enabled');
        $formMapper->add('authorName');
        $formMapper->add('cdnIsFlushable');
        $formMapper->add('description');
        $formMapper->add('copyright');
        $formMapper->add('binaryContent', array(), array('type' => 'string'));
    }

    public function prePersist(MediaInterface $media)
    {
        if (!$media->getBinaryContent()) {

            return;
        }

        // retrieve metadata
        $metadata = $this->getMetadata($media);

        // store provider information
        $media->setProviderName($this->name);
        $media->setProviderReference($media->getBinaryContent());
        $media->setProviderMetadata($metadata);

        // update Media common field from metadata
        $media->setName($metadata['title']);
        $media->setDescription($metadata['description']);
        $media->setAuthorName($metadata['author_name']);
        $media->setHeight($metadata['height']);
        $media->setWidth($metadata['width']);
        $media->setContentType('audio/mpeg');
        $media->setProviderStatus(Media::STATUS_OK);
    }
    public function preUpdate(MediaInterface $media)
    {
        if (!$media->getBinaryContent()) {

            return;
        }

        $metadata = $this->getMetadata($media);

        $media->setProviderReference($media->getBinaryContent());
        $media->setProviderMetadata($metadata);
        $media->setHeight($metadata['height']);
        $media->setWidth($metadata['width']);
        $media->setProviderStatus(Media::STATUS_OK);

        $media->setUpdatedAt(new \Datetime());
    }

    /**
     * @param MediaInterface $media
     */
    public function postPersist(MediaInterface $media)
    {
        if (!$media->getBinaryContent()) {

            return;
        }
    }

    /**
     * @param MediaInterface $media
     * @param string $format
     * @param array $options
     */
    public function getHelperProperties(MediaInterface $media, $format, $options = array())
    {
        // TODO: Implement getHelperProperties() method.
    }

    /**
     * Generate the public path.
     *
     * @param MediaInterface $media
     * @param string $format
     *
     * @return string
     */
    public function generatePublicUrl(MediaInterface $media, $format)
    {
        return sprintf('http://foobar.com/%s', $media->getProviderReference());
    }



    public function getMetadata(MediaInterface $media)
    {
        if (!$media->getBinaryContent()) {

            return;
        }

        $url = sprintf('http://soundcloud.com/api/oembed.json?url=http://soundcloud.com/%s', $media->getBinaryContent());
        $metadata = @file_get_contents($url);

        if (!$metadata) {
            throw new \RuntimeException('Unable to retrieve soundcloud information for :' . $url);
        }

        $metadata = json_decode($metadata, true);

        if (!$metadata) {
            throw new \RuntimeException('Unable to decode soundcloud information for :' . $url);
        }

        return $metadata;
    }
}