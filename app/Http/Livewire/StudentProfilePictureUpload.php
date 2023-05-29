<?php

namespace App\Http\Livewire;

use App\Models\Student;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class StudentProfilePictureUpload extends Component
{
    use WithFileUploads;

    public $student;
    public $photo;

    public function mount($student_id)
    {
        $this->student = Student::where('student_id', $student_id)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.student-profile-picture-upload');
    }

    public function updatedPhoto()
    {
        $this->validate([
            /* This is a validation rule for the uploaded photo file. It checks that the file has a
            mime type of either "jpg" or "png", has a maximum file size of 10240 kilobytes, and has
            minimum dimensions of 450 pixels width and 600 pixels height. If the uploaded file does
            not meet these requirements, it will fail validation and an error message will be
            displayed to the user. */
            'photo' => 'mimes:jpg,png|max:5120|dimensions:min_width=450,min_height=600',
        ]);

        $photoname = $this->student->student_id . md5(now()) . '.jpg';
        Image::make($this->photo)->fit(450, 600)->save('storage/student-pictures/' . $photoname);


        $this->student->profile_photo = $photoname;
        $this->student->save();

        session()->flash('success', 'Photo Saved.');
    }

    public function deletePhoto()
    {
        if (File::exists(config('settings.system.path') . 'storage/student-pictures/' . $this->student->profile_photo)) {
            File::delete(config('settings.system.path') . 'storage/student-pictures/' . $this->student->profile_photo);
        }
        $this->student->profile_photo = NULL;
        $this->student->save();

        session()->flash('success', 'Photo Deleted.');
    }
}
