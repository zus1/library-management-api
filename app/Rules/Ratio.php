<?php

namespace App\Rules;

use App\Const\ImageSize;
use App\Const\ImageType;
use App\Helper\UploadHelper;
use App\Interface\ImageOwnerInterface;
use App\Models\Librarian;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class Ratio implements ValidationRule
{
    public function __construct(
        private Request $request,
        private UploadHelper $uploadHelper,
    ){
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(! $value instanceof UploadedFile) {
            $fail('Error: Value needs to be instance of '.UploadedFile::class);
        }

        $dimensions = $value->dimensions();

        $neededRation = $this->getRatio();
        $ratio = $dimensions[1]/$dimensions[0];

        $lowerBoundary = $neededRation - 0.2;
        $upperBoundary = $neededRation + 0.2;

        if($ratio < $lowerBoundary || $ratio > $upperBoundary) {
            $fail(sprintf(
                'Dimension ratio (height/with) for %s needs to be between %f and %f',
                $attribute,
                $lowerBoundary,
                $upperBoundary
            ));
        }
    }

    private function getRatio(): float
    {
        /** @var ImageOwnerInterface $owner */
        $owner = $this->request->route('owner', new Librarian());

        $type = $this->uploadHelper->getSingularPrefix($owner);

        return ImageType::getRatio($type);
    }
}
