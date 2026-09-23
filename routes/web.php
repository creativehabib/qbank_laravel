<?php

use App\Http\Controllers\BackupDownloadController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\InteractionController;
use App\Http\Controllers\Frontend\JobSolutionController;
use App\Http\Controllers\Frontend\ToolsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PdfGeneratorController;
use App\Http\Controllers\Pages\AcademicClasses\ClassIndex;
use App\Http\Controllers\Pages\Admin\ModelTests\ModelTestCreate;
use App\Http\Controllers\Pages\Admin\ModelTests\ModelTestIndex;
use App\Http\Controllers\Pages\Admin\Organizations\OrganizationIndex;
use App\Http\Controllers\Pages\Admin\PackageManagement;
use App\Http\Controllers\Pages\Admin\PastExams\PastExamIndex;
use App\Http\Controllers\Pages\Admin\PastExams\PastExamManager;
use App\Http\Controllers\Pages\Admin\Settings\AiSetting;
use App\Http\Controllers\Pages\Admin\Settings\BrandingTheme;
use App\Http\Controllers\Pages\Admin\Settings\EmailSetting;
use App\Http\Controllers\Pages\Admin\Settings\FooterSetting;
use App\Http\Controllers\Pages\Admin\Settings\GeneralSetting;
use App\Http\Controllers\Pages\Admin\Settings\Index;
use App\Http\Controllers\Pages\Admin\Settings\Languages;
use App\Http\Controllers\Pages\Admin\Settings\MenuBuilder;
use App\Http\Controllers\Pages\Admin\Settings\PaymentSetting;
use App\Http\Controllers\Pages\Admin\Settings\SeoSetting;
use App\Http\Controllers\Pages\Admin\Settings\ThemeOptions;
use App\Http\Controllers\Pages\Admin\Settings\WebsiteTracking;
use App\Http\Controllers\Pages\Admin\WalletApprovalPanel;
use App\Http\Controllers\Pages\Chapters\ChapterIndex;
use App\Http\Controllers\Pages\ExamCategories\ExamCategoriesIndex;
use App\Http\Controllers\Pages\OMR\EvaluateOmr;
use App\Http\Controllers\Pages\OMR\ManageTokens;
use App\Http\Controllers\Pages\OMR\MapAnswers;
use App\Http\Controllers\Pages\OmrGenerator;
use App\Http\Controllers\Pages\OmrScanner;
use App\Http\Controllers\Pages\PermissionManager;
use App\Http\Controllers\Pages\Questions;
use App\Http\Controllers\Pages\Questions\BulkUpload;
use App\Http\Controllers\Pages\Questions\Create;
use App\Http\Controllers\Pages\Questions\Edit;
use App\Http\Controllers\Pages\RolePermissionManager;
use App\Http\Controllers\Pages\Students\BookmarkedQuestions;
use App\Http\Controllers\Pages\Students\CheckoutPage;
use App\Http\Controllers\Pages\Students\GoalSelection;
use App\Http\Controllers\Pages\Students\Leaderboard;
use App\Http\Controllers\Pages\Students\MistakeReview;
use App\Http\Controllers\Pages\Students\MockTestHistory;
use App\Http\Controllers\Pages\Students\MockTestResult;
use App\Http\Controllers\Pages\Students\ModelTests\ModelTestAttempt;
use App\Http\Controllers\Pages\Students\ModelTests\ModelTestResultPage;
use App\Http\Controllers\Pages\Students\PerformanceAnalytics;
use App\Http\Controllers\Pages\Students\PracticeIndex as StudentPracticeIndex;
use App\Http\Controllers\Pages\Students\PricingPage;
use App\Http\Controllers\Pages\Students\TakeMockTest;
use App\Http\Controllers\Pages\Subjects\SubjectIndex;
use App\Http\Controllers\Pages\SuperAdmin\Settings\ActivityLogs;
use App\Http\Controllers\Pages\SuperAdmin\Settings\Backups;
use App\Http\Controllers\Pages\SuperAdmin\Settings\CacheManagement;
use App\Http\Controllers\Pages\SuperAdmin\Settings\Htaccess;
use App\Http\Controllers\Pages\SuperAdmin\Settings\RobotsTxtSetting;
use App\Http\Controllers\Pages\SuperAdmin\Settings\SitemapSetting;
use App\Http\Controllers\Pages\SuperAdmin\Settings\SystemInformation;
use App\Http\Controllers\Pages\Tags\Index as TagIndex;
use App\Http\Controllers\Pages\Teacher\CreateQuestionSet;
use App\Http\Controllers\Pages\Teacher\GeneratedQuestionSetPage;
use App\Http\Controllers\Pages\Teacher\MyEarnings;
use App\Http\Controllers\Pages\Teacher\MyQuestionSets;
use App\Http\Controllers\Pages\Teacher\OrganizationInfo;
use App\Http\Controllers\Pages\Teacher\PackageCheckout;
use App\Http\Controllers\Pages\Teacher\PricingPlans;
use App\Http\Controllers\Pages\Teacher\QuestionGenerator;
use App\Http\Controllers\Pages\Teacher\QuestionPaper;
use App\Http\Controllers\Pages\Teacher\SubscriptionOverview;
use App\Http\Controllers\Pages\Teacher\ViewQuestions;
use App\Http\Controllers\Pages\Teacher\WalletTransactions;
use App\Http\Controllers\Pages\Topics\TopicIndex;
use App\Http\Controllers\Pages\UserRoleManagement;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendController::class, 'home'])->name('home');

// Tools Group Route
Route::prefix('tools')->name('tools.')->group(function () {

    // টুলস এর মূল পেজ (যেখানে সব টুলের তালিকা বা মেনু থাকবে)
    Route::get('/', [ToolsController::class, 'index'])->name('index');

    // পে-স্কেল ক্যালকুলেটর
    Route::get('/payscale-calculator', [ToolsController::class, 'payscaleCalculate'])->name('payscale_calculate');

    // ভবিষ্যতে যুক্ত হতে পারে এমন আরও কিছু টুলের উদাহরণ
    Route::get('/age-calculator', [ToolsController::class, 'ageCalculator'])->name('age_calculator');
    Route::get('/cgpa-calculator', [ToolsController::class, 'cgpaCalculator'])->name('cgpa_calculator');
    Route::get('/unit-converter', [ToolsController::class, 'unitConverter'])->name('unit_converter');

});

// Pages Group Route
Route::prefix('pages')->name('pages.')->group(function () {
    Route::view('/privacy-policy', 'frontend.pages.privacy-policy')->name('privacy');
});

// Public Frontend Routes
Route::get('/job-solutions', [JobSolutionController::class, 'index'])->name('job-solutions.index');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::patch('/dashboard/question-sets/{questionSet}', [DashboardController::class, 'updateQuestionSet'])->middleware('role:super_admin')->name('dashboard.question-sets.update');
    Route::delete('/dashboard/question-sets/{questionSet}', [DashboardController::class, 'destroyQuestionSet'])->middleware('role:super_admin')->name('dashboard.question-sets.destroy');

    // --- প্রশ্ন ভান্ডার (Question Bank) Routes ---
    Route::match(['get', 'post'], '/questions', Questions::class)->name('questions.index');
    Route::match(['get', 'post'], '/questions/create', Create::class)->name('questions.create');
    //    Route::match(['get', 'post'], '/questions/{question}/show', App\Http\Controllers\Pages\ShowQuestion::class)->name('questions.show');
    Route::match(['get', 'post'], '/questions/bulk-upload', BulkUpload::class)->name('questions.bulk-upload');
    Route::match(['get', 'post'], '/questions/{question}/edit', Edit::class)->name('questions.edit');

    Route::middleware('permission:exam_categories.manage')->group(function (): void {
        Route::match(['get', 'post'], '/exam-categories', ExamCategoriesIndex::class)->name('exam-categories.index');
    });

    Route::middleware('permission:academic_classes.manage')->group(function (): void {
        Route::match(['get', 'post'], '/academic-classes', ClassIndex::class)->name('academic-classes.index');
    });

    Route::middleware('permission:subjects.manage')->group(function (): void {
        Route::match(['get', 'post'], '/subjects', SubjectIndex::class)->name('subjects.index');
    });

    Route::middleware('permission:chapters.manage')->group(function (): void {
        Route::match(['get', 'post'], '/chapters', ChapterIndex::class)->name('chapters.index');
    });

    Route::middleware('permission:topics.manage')->group(function (): void {
        Route::match(['get', 'post'], '/topics', TopicIndex::class)->name('topics.index');
    });

    Route::middleware('permission:tags.create|tags.update|tags.delete')->group(function (): void {
        Route::match(['get', 'post'], '/tags', TagIndex::class)->name('tags.index');
    });

    Route::middleware('permission:users.manage_roles')->group(function (): void {
        Route::match(['get', 'post'], '/users', UserRoleManagement::class)->name('users.index');

        Route::match(['get', 'post'], '/admin/theme-options', ThemeOptions::class)->name('admin.theme-options');
        Route::match(['get', 'post'], '/admin/wallet-approvals', WalletApprovalPanel::class)->name('admin.wallet-approvals');
        Route::match(['get', 'post'], '/admin/packages', PackageManagement::class)->name('admin.packages');
        Route::get('/admin/theme-options/fonts', function () {
            return Cache::remember('theme-options-fonts', now()->addHours(12), function () {
                $response = Http::timeout(20)->get('https://cdn.jsdelivr.net/gh/hasinhayder/google-fonts/fonts.json');

                if (! $response->successful()) {
                    return [];
                }

                return $response->json();
            });
        })->name('admin.theme-options.fonts');
    });

    Route::middleware('role:admin|super_admin')->group(function (): void {
        // Model Tests (Admin created Mock Tests)
        Route::match(['get', 'post'], '/admin/model-tests', ModelTestIndex::class)->name('admin.model-tests.index');
        Route::match(['get', 'post'], '/admin/model-tests/create', ModelTestCreate::class)->name('admin.model-tests.create');

        // Organizations & Past Exams
        Route::match(['get', 'post'], '/admin/organizations', OrganizationIndex::class)->name('admin.organizations.index');
        Route::match(['get', 'post'], '/admin/past-exams', PastExamIndex::class)->name('admin.past-exams.index');
        Route::match(['get', 'post'], '/admin/past-exams/{pastExamId}/manage', PastExamManager::class)->name('admin.past-exams.manage');

        // Admin Settings
        Route::match(['get', 'post'], '/admin/settings', Index::class)->name('admin.settings.index');
        Route::match(['get', 'post'], '/admin/settings/general', GeneralSetting::class)->name('admin.settings.general');
        Route::match(['get', 'post'], '/admin/settings/menus', MenuBuilder::class)->name('admin.settings.menus');
        Route::match(['get', 'post'], '/admin/settings/seo', SeoSetting::class)->name('admin.settings.seo');
        Route::match(['get', 'post'], '/admin/settings/footer', FooterSetting::class)->name('admin.settings.footer');
        Route::match(['get', 'post'], '/admin/settings/branding-theme', BrandingTheme::class)->name('admin.settings.branding');
        Route::match(['get', 'post'], '/admin/settings/email', EmailSetting::class)->name('admin.settings.email');
        Route::match(['get', 'post'], '/admin/settings/ai', AiSetting::class)->name('admin.settings.ai');
        Route::match(['get', 'post'], '/admin/settings/languages', Languages::class)->name('admin.settings.languages');
        Route::match(['get', 'post'], '/admin/settings/tracking', WebsiteTracking::class)->name('admin.settings.tracking');
        Route::match(['get', 'post'], '/admin/settings/payment', PaymentSetting::class)->name('admin.settings.payment');

        // Super Admin Settings
        Route::match(['get', 'post'], '/superadmin/settings/sitemap', SitemapSetting::class)->middleware('role:super_admin')->name('superadmin.settings.sitemap');
        Route::match(['get', 'post'], '/superadmin/settings/robots-txt', RobotsTxtSetting::class)->middleware('role:super_admin')->name('superadmin.settings.robots-txt');
        Route::match(['get', 'post'], '/superadmin/settings/htaccess', Htaccess::class)->middleware('role:super_admin')->name('superadmin.settings.htaccess');
        Route::match(['get', 'post'], '/superadmin/settings/backups', Backups::class)->middleware('role:super_admin')->name('superadmin.settings.backups');
        Route::get('/superadmin/settings/backups/download', [BackupDownloadController::class, 'download'])->middleware('role:super_admin')->name('superadmin.settings.backups.download');
        Route::match(['get', 'post'], '/superadmin/settings/cache', CacheManagement::class)->middleware('role:super_admin')->name('superadmin.settings.cache');
        Route::match(['get', 'post'], '/superadmin/settings/system-info', SystemInformation::class)->middleware('role:super_admin')->name('superadmin.settings.system-info');
        Route::match(['get', 'post'], '/superadmin/settings/activity-logs', ActivityLogs::class)->middleware('role:super_admin')->name('superadmin.settings.activity-logs');
    });

    Route::middleware('permission:users.manage_permissions')->group(function (): void {
        Route::match(['get', 'post'], '/permissions', PermissionManager::class)->name('permissions.index');
        Route::match(['get', 'post'], '/roles-permissions', RolePermissionManager::class)->name('roles-permissions.index');
    });

    Route::get('/question-set/{id}/download-pdf', [PdfGeneratorController::class, 'downloadQuestionPaper'])
        ->name('pdf.download')
        ->middleware('auth');

    Route::match(['get', 'post'], '/teacher/question-set-create', CreateQuestionSet::class)->name('question.set-create');
    Route::match(['get', 'post'], '/teacher/create-question/generated-qset/{qset}', GeneratedQuestionSetPage::class)->name('qset.generated');
    Route::match(['get', 'post'], '/teacher/view-questions', ViewQuestions::class)->name('questions.view');
    Route::match(['get', 'post'], '/teacher/question-create', QuestionGenerator::class)->name('teacher.questions.generate');
    Route::match(['get', 'post'], '/teacher/my-question-sets', MyQuestionSets::class)->name('teacher.questions.index');
    Route::match(['get', 'post'], '/teacher/questions-paper', QuestionPaper::class)->name('questions.paper');
    Route::match(['get', 'post'], '/teacher/organization-info', OrganizationInfo::class)->middleware('role:teacher')->name('teacher.organization-info');
    Route::match(['get', 'post'], '/teacher/subscription', SubscriptionOverview::class)->middleware('role:teacher')->name('teacher.subscription');
    Route::match(['get', 'post'], '/teacher/pricing', PricingPlans::class)->middleware('role:teacher')->name('teacher.pricing');
    Route::match(['get', 'post'], '/teacher/pricing/checkout/{package}', PackageCheckout::class)->middleware('role:teacher')->name('teacher.pricing.checkout');
    Route::match(['get', 'post'], '/teacher/earnings', MyEarnings::class)->middleware('role:teacher')->name('teacher.earnings');
    Route::match(['get', 'post'], '/teacher/wallet', WalletTransactions::class)->middleware('role:teacher')->name('teacher.wallet');

    Route::match(['get', 'post'], '/student/goals', GoalSelection::class)->name('student.goals');
    Route::match(['get', 'post'], '/student/practice', StudentPracticeIndex::class)->name('students.practice.index');
    Route::match(['get', 'post'], '/student/bookmarks', BookmarkedQuestions::class)->name('student.bookmarks');
    Route::match(['get', 'post'], '/student/mock-test/{testId}', TakeMockTest::class)->name('student.mock-test.take');
    Route::match(['get', 'post'], '/student/mock-test/{testId}/result', MockTestResult::class)->name('student.mock-test.result');

    // New Model Tests (Admin Created)
    Route::match(['get', 'post'], '/student/model-tests', App\Http\Controllers\Pages\Students\ModelTests\ModelTestIndex::class)->name('student.model-tests.index');
    Route::match(['get', 'post'], '/student/model-tests/{modelTest}', ModelTestAttempt::class)->name('student.model-tests.attempt');
    Route::match(['get', 'post'], '/student/model-tests/result/{resultId}', ModelTestResultPage::class)->name('student.model-tests.result');
    Route::match(['get', 'post'], '/student/leaderboard', Leaderboard::class)->name('student.leaderboard');
    Route::match(['get', 'post'], '/student/mistakes', MistakeReview::class)->name('student.mistakes');
    Route::match(['get', 'post'], '/student/test-history', MockTestHistory::class)->name('student.test-history');
    Route::match(['get', 'post'], '/student/analytics', PerformanceAnalytics::class)->name('student.analytics');
    Route::match(['get', 'post'], '/student/pricing', PricingPage::class)->name('student.pricing');
    Route::match(['get', 'post'], '/student/checkout/{package_id}', CheckoutPage::class)->name('student.checkout');
    Route::match(['get', 'post'], '/student/omr-scanner', OmrScanner::class)->name('student.omr-scanner');

    Route::match(['get', 'post'], '/tokens', ManageTokens::class)->name('tokens.list');
    Route::match(['get', 'post'], '/tokens/{token_id}/map', MapAnswers::class)->name('tokens.map-answers');
    Route::match(['get', 'post'], '/omr/evaluate', EvaluateOmr::class)->name('omr.evaluate');

    Route::middleware('role:teacher|admin|super_admin')->group(function (): void {
        Route::match(['get', 'post'], '/omr-generator', OmrGenerator::class)->name('omr.generator');
    });
});

// Payment Initiation Routes (Must be logged in)
Route::middleware(['auth'])->group(function () {
    Route::post('/payment/bkash/pay/{package}', [PaymentController::class, 'bkashPay'])->name('payment.bkash.pay');
    Route::post('/payment/ssl/pay/{package}', [PaymentController::class, 'sslPay'])->name('payment.ssl.pay');
});

// Payment Callback Routes (Session might be dropped by browser due to cross-site POST)
Route::get('/payment/bkash/callback', [PaymentController::class, 'bkashCallback'])->name('payment.bkash.callback');
Route::post('/payment/ssl/success', [PaymentController::class, 'sslSuccess'])->name('payment.ssl.success');
Route::post('/payment/ssl/fail', [PaymentController::class, 'sslFail'])->name('payment.ssl.fail');
Route::post('/payment/ssl/cancel', [PaymentController::class, 'sslCancel'])->name('payment.ssl.cancel');
// SSL IPN is usually not authenticated
Route::post('/payment/ssl/ipn', [PaymentController::class, 'sslIpn'])->name('payment.ssl.ipn');

// Nagad Payment Routes
Route::post('/payment/nagad/pay/{package}', [PaymentController::class, 'nagadPay'])->name('payment.nagad.pay');
Route::get('/payment/nagad/callback', [PaymentController::class, 'nagadCallback'])->name('payment.nagad.callback');

// Interaction Routes (AJAX)
Route::middleware(['auth'])->group(function () {
    Route::post('/interaction/bookmark/{id}', [InteractionController::class, 'toggleBookmark']);
    Route::post('/interaction/like/{id}', [InteractionController::class, 'toggleLike']);
    Route::post('/interaction/ai-explanation/{id}', [InteractionController::class, 'generateAiExplanation']);
});

require __DIR__.'/settings.php';

Route::get('/search', [FrontendController::class, 'search'])->name('search');
Route::get('/search/live', [FrontendController::class, 'apiSearch'])->name('search.live');

Route::get('/question/{slug}', [JobSolutionController::class, 'questionShow'])->name('question.show');

// Dynamic Organization and Exam Routes (Place at very bottom to prevent overriding)
Route::get('/{organizationSlug}', [JobSolutionController::class, 'organizationShow'])->name('organization.show');
Route::get('/{organizationSlug}/{examSlug}', [JobSolutionController::class, 'show'])->name('job-solutions.show');
