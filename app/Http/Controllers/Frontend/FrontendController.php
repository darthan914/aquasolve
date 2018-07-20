<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Careers;
use App\Models\Certification;
use App\Models\GeneralConfig;
use App\Models\Inbox;
use App\Models\News;
use App\Models\Overseas;
use App\Models\Partner;
use App\Models\ProdukCategory;
use App\Models\SolutionsCategory;
use App\Models\SolutionsImg;
use App\Models\JobApply;
use DB;
use File;
use Illuminate\Http\Request;
use Validator;

use Mail;

class FrontendController extends Controller
{
    public function home()
    {
        $about    = GeneralConfig::find(8);
        $facility = GeneralConfig::find(9);
        $Banner   = Banner::where('flug_publish', 'Y')->get();
        $News     = News::where('flug_publish', 'Y')->orderBy('id', 'desc')->limit(3)->get();

        return view('frontend.home-page.index', compact(
            'about',
            'facility',
            'Banner',
            'News'
        ));
    }

    public function about()
    {
        $about         = GeneralConfig::find(8);
        $facility      = GeneralConfig::find(9);
        $vidio         = GeneralConfig::find(10);
        $Certification = Certification::where('flug_publish', 'Y')->get();

        return view('frontend.about-page.index', compact(
            'about',
            'facility',
            'vidio',
            'Certification'
        ));
    }

    public function contact()
    {
        return view('frontend.contact-page.index');
    }
    public function contactStore(Request $request)
    {
        $message = [
            'name.required'    => 'required',
            'name.min'         => 'to short',
            'email.required'   => 'required',
            'email.email'      => 'format email salah',
            'subject.required' => 'required',
            'subject.min'      => 'to short',
            'message.required' => 'required',
            'message.min'      => 'to short',
            'message.max'      => 'to long',
            // 'g-recaptcha-response.required'  => 'required',
        ];

        $validator = Validator::make($request->all(), [
            'name'    => 'required|min:3',
            'email'   => 'required|email',
            'subject' => 'required|min:3',
            'message' => 'required|min:10|max:580',
            // 'g-recaptcha-response' => 'required',
        ], $message);

        if ($validator->fails()) {
            return redirect()
                ->route('frontend.contact')
                ->withErrors($validator)
                ->withInput()
                ->with('autofocus', true)
                ->with('info', 'Invalid...!')
                ->with('alert', 'alert-danger');
        }

        if (!str_contains($request->email, ['gmail', 'yahoo', 'ymail', 'hotmail'])) {
            return redirect()
                ->route('frontend.contact')
                ->with('autofocus', true)
                ->with('info', 'Success...!')
                ->with('alert', 'alert-success');
        }
        if (str_contains($request->pesan, ['href', 'http', 'https', 'porn', 'pocker'])) {
            return redirect()
                ->route('frontend.contact')
                ->with('autofocus', true)
                ->with('info', 'Success...!')
                ->with('alert', 'alert-success');
        }

        DB::transaction(function () use ($request) {

            $save          = new Inbox;
            $save->name    = $request->name;
            $save->email   = $request->email;
            $save->subyek  = $request->subject;
            $save->message = $request->message;
            $save->save();

            //     $getSendTo = General::first();

            //     try {
            //       Mail::send('frontend.kontak-page.mail', ['request' => $request], function($message) use ($request, $getSendTo) {
            //         $message->from('administrator@pancalogam.com', 'Administrator')
            //                 ->to($getSendTo->email_to);
            //         if ($getSendTo->email_cc != null) {
            //                 $message->cc($getSendTo->email_cc);
            //         }
            //                 $message->subject('New Inbox From : '.$request->email);
            //       });
            //     } catch (\Exception $e) {
            //       // dd($e);
            //     }
        });

        return redirect()
            ->route('frontend.contact')
            ->with('autofocus', true)
            ->with('info', 'Success...!')
            ->with('alert', 'alert-success');
    }

    public function product($slug = null, $subslug = null)
    {
        $slugId = null;
        if ($slug != null) {
            $slugId = ProdukCategory::where('slug', $slug)->first();
            if ($slugId == null) {
                return view('errors.404');
            }
        }
        return view('frontend.product-page.index', compact('slug', 'subslug', 'slugId'));
    }

    public function solutions()
    {
        $SolutionsCategory = SolutionsCategory::where('flug_publish', 'Y')->orderBy('id', 'desc')->get();
        $SolutionsImg      = SolutionsImg::where('flug_publish', 'Y')->orderBy('id', 'desc')->get();

        return view('frontend.solutions-page.index', compact('SolutionsImg', 'SolutionsCategory'));
    }

    public function news()
    {
        $News = News::where('flug_publish', 'Y')->orderBy('id', 'desc')->paginate(4);
        return view('frontend.news-page.index', compact('News'));
    }
    public function newsView($slug)
    {
        $News = News::where('flug_publish', 'Y')->where('slug', $slug)->first();
        if ($News == null) {
            return view('errors.404');
        }
        $NewsHot = News::where('flug_publish', 'Y')->orderBy('id', 'desc')->limit(7)->get();

        return view('frontend.news-page.view', compact(
            'News',
            'NewsHot'
        ));
    }

    public function distribution()
    {
        $Partner  = Partner::where('flag_publish', '1')->get();
        $Overseas = Overseas::where('flug_publish', 'Y')->get();
        return view('frontend.distribution-page.index', compact('Partner', 'Overseas'));
    }

    public function careers()
    {
        $careers = GeneralConfig::find(11);
        $Careers = Careers::where('flug_publish', 'Y')->get();

        return view('frontend.careers-page.index', compact(
            'careers',
            'Careers'
        ));
    }
    public function careersStore(Request $request)
    {
        $message = [
            'name.required'    => 'required',
            'name.min'         => 'to short',
            'email.required'   => 'required',
            'email.email'      => 'format email salah',
            'telp.required'    => 'required',
            'telp.min'         => 'to short',
            'position.required'    => 'required',
            'position.min'         => 'to short',
            'message.required' => 'required',
            'message.min'      => 'to short',
            'message.max'      => 'to long',
            'file.required'    => 'required',
            'file.max'         => 'Max 5 MB',
            // 'g-recaptcha-response.required'  => 'required',
        ];

        $validator = Validator::make($request->all(), [
            'name'     => 'required|min:3',
            'email'    => 'required|email',
            'telp'     => 'required|min:3',
            'position' => 'required|min:3',
            'message'  => 'required|min:10|max:580',
            'file'     => 'required|max:5000',
            // 'g-recaptcha-response' => 'required',
        ], $message);

        if ($validator->fails()) {
            return redirect()
                ->route('frontend.careers')
                ->withErrors($validator)
                ->withInput()
                ->with('autofocus', true)
                ->with('info', 'Invalid...!')
                ->with('alert', 'alert-danger');
        }

        if (!str_contains($request->email, ['gmail', 'yahoo', 'ymail', 'hotmail'])) {
            return redirect()
                ->route('frontend.careers')
                ->withErrors($validator)
                ->with('autofocus', true)
                ->with('info', 'Invalid...!')
                ->with('alert', 'alert-danger');
        }

        DB::transaction(function () use ($request) {

            $salt     = str_random(4);

            $pathSource = 'amadeo/file/';
            $file       = $request->file('file');
            $filename   = $file->getClientOriginalName() . '-' . $salt . '.' . $file->getClientOriginalExtension();
            $file->move($pathSource, $filename);

            $save           = new JobApply;
            $save->name     = $request->name;
            $save->email    = $request->email;
            $save->telp     = $request->telp;
            $save->position = $request->position;
            $save->message  = $request->message;
            $save->file     = $pathSource . $filename;

            $save->save();

            // $data = array(
            //     'name' => $request->name,
            //     'email' => $request->email,
            //     'telp' => $request->telp,
            //     'position' => $request->position,
            //     'bodyMessage' => $request->message,
            //     'file' => $pathSource . $filename,
            //     'to' => GeneralConfig::find(15)->content,
            // );

            // Mail::send('frontend.emails.index', $data, function($message) use ($data, $request) {
            //     $message->from($data['email']);
            //     $message->to($data['to']);
            //     $message->subject('Request for ' . $data['position']);
            // });

        });

        return redirect()
            ->route('frontend.careers')
            ->with('autofocus', true)
            ->with('info', 'Success...!')
            ->with('alert', 'alert-success');
    }
}
