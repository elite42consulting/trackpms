<?php

namespace elite42\trackpms\types;


/**
 * @see https://developer.trackhs.com/reference/getcustomfields
 */
class customField
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public int    $id           = 0;

	public string $entity       = '';

	public string $name         = '';

	public string $reference    = '';

	public string $type         = '';

	public string $subType      = '';

	public ?int   $displayOrder = null;

	public ?\elite42\trackpms\types\customField\additionalProperties $additionalProperties = null;

	public bool                                                      $isRequired           = false;

	public bool                                                      $isExportable         = false;

	public bool                                                      $isMergeField         = false;

	public bool                                                      $isCondition          = false;

	public bool                                                      $isVisible            = false;

	public bool                                                      $isEditable           = false;

	public string                                                    $defaultValue         = '';

	public bool                                                      $changeDetection      = false;

	public ?\DateTimeImmutable                                       $createdAt            = null;

	public string                                                    $createdBy            = '';

	public ?\DateTimeImmutable                                       $updatedAt            = null;

	public string                                                    $updatedBy            = '';

	public ?\elite42\trackpms\types\customField\customFieldEmbedded  $_embedded            = null;

	public ?\elite42\trackpms\types\_envelope\_links                 $_links               = null;

}