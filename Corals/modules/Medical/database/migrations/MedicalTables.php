<?php

namespace Corals\Modules\Medical\database\migrations;

use Corals\Modules\Medical\Enums\ClinicStatuses;
use Corals\Modules\Medical\Enums\FrequencyUnit;
use Corals\Modules\Medical\Enums\GenderStatus;
use Corals\Modules\Medical\Enums\MaritalStatus;
use Corals\Modules\Medical\Enums\PaymentTypes;
use Corals\Modules\Medical\Enums\PrescriptionTypes;
use Corals\Modules\Medical\Enums\VisitStatuses;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MedicalTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('medical_cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $this->commonColumns($table);
        });

        Schema::create('medical_villages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('city_id')->index();
            $table->foreign('city_id')->references('id')->on('medical_cities');
            $this->commonColumns($table);
        });

        Schema::create('medical_clinics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('address');
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->string('small_logo')->nullable();
            $table->string('status')->default(ClinicStatuses::Active->value);
            $table->unsignedInteger('currency_id')->index();
            $table->foreign('currency_id')->references('id')->on('currencies');
            $this->commonColumns($table);
        });

        Schema::create('medical_patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('national_id', 64)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('phone_number', 30)->nullable();
            $table->string('gender')->default(GenderStatus::Male->value);
            $table->string('marital')->default(MaritalStatus::Single->value);
            $table->unsignedBigInteger('city_id')->index();
            $table->foreign('city_id')->references('id')->on('medical_cities');
            $table->unsignedBigInteger('village_id')->index();
            $table->foreign('village_id')->references('id')->on('medical_villages');
            $table->unsignedBigInteger('clinic_id')->index();
            $table->foreign('clinic_id')->references('id')->on('medical_clinics');
            $this->commonColumns($table);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('clinic_id')->nullable()->after('phone_number')->index();
            $table->foreign('clinic_id')->references('id')->on('medical_clinics');
        });

        Schema::create('medical_allergies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('patient_id')->index();
            $table->foreign('patient_id')->references('id')->on('medical_patients');
            $this->commonColumns($table);
        });

        Schema::create('medical_visits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id')->index();
            $table->foreign('clinic_id')->references('id')->on('medical_clinics');
            $table->unsignedBigInteger('patient_id')->index();
            $table->foreign('patient_id')->references('id')->on('medical_patients');
            $table->unsignedInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('visit_status')->default(VisitStatuses::Waiting->value);
            $table->timestamp('scheduled_at');
            $table->smallInteger('duration_minutes')->unsigned()->default(15);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2)->default(0);
            $table->decimal('total_paid', 10, 2)->default(0);
            $table->string('payment_type')->default(PaymentTypes::Cash->value);
            $this->commonColumns($table);
        });

        Schema::create('medical_services', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('base_price', 10, 2)->default(0);
            $table->unsignedBigInteger('clinic_id')->index();
            $table->foreign('clinic_id')->references('id')->on('medical_clinics');
            $this->commonColumns($table);
        });

        Schema::create('medical_visits_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visit_id')->index();
            $table->foreign('visit_id')->references('id')->on('medical_visits');
            $table->unsignedBigInteger('service_id')->index();
            $table->foreign('service_id')->references('id')->on('medical_services');
            $table->unsignedBigInteger('quantity')->default(1);
            $table->decimal('price', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $this->commonColumns($table);
        });

        Schema::create('medical_medicine_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $this->commonColumns($table);
        });

        Schema::create('medical_medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('generic_name')->nullable();
            $this->commonColumns($table);
        });

        Schema::create('medical_prescriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visit_id')->index();
            $table->foreign('visit_id')->references('id')->on('medical_visits');
            $table->string('type')->default(PrescriptionTypes::Normal->value);
            $this->commonColumns($table);
        });

        Schema::create('medical_prescription_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prescription_id')->index();
            $table->foreign('prescription_id')->references('id')->on('medical_prescriptions');
            $table->unsignedBigInteger('medicine_id')->nullable()->index();
            $table->foreign('medicine_id')->references('id')->on('medical_medicines');
            $table->unsignedBigInteger('medicine_type_id')->nullable()->index();
            $table->foreign('medicine_type_id')->references('id')->on('medical_medicine_types');
            $table->unsignedBigInteger('quantity')->nullable();
            $table->unsignedBigInteger('times')->nullable();
            $table->unsignedBigInteger("taken_quantity");
            $table->unsignedBigInteger("taken_frequency");
            $table->string('frequency_unit')->default(FrequencyUnit::Days->value);
            $table->unsignedBigInteger("duration_value");
            $table->string('duration_unit')->default(FrequencyUnit::Days->value);
            $table->text('notes')->nullable();
            $this->commonColumns($table);
        });

        Schema::create('medical_question_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('public_name')->nullable();
            $this->commonColumns($table);
        });

        Schema::create('medical_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id')->index();
            $table->foreign('clinic_id')->references('id')->on('medical_clinics');
            $table->unsignedInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('form_title');
            $table->boolean('is_active')->default(true);
            $this->commonColumns($table);
        });

        Schema::create('medical_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id')->index();
            $table->foreign('form_id')->references('id')->on('medical_forms');
            $table->string('title');
            $table->smallInteger('order')->unsigned()->default(1);
            $table->text('description')->nullable();
            $this->commonColumns($table);
        });

        Schema::create('medical_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('section_id')->index();
            $table->foreign('section_id')->references('id')->on('medical_sections');
            $table->smallInteger('order')->unsigned()->default(1);
            $table->unsignedBigInteger('type_id')->index();
            $table->foreign('type_id')->references('id')->on('medical_question_types');
            $table->string('label');
            $table->boolean('is_required')->default(false);
            $table->text('help_text')->nullable();
            $this->commonColumns($table);
        });

        Schema::create('medical_question_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id')->index();
            $table->foreign('question_id')->references('id')->on('medical_questions');
            $table->string('key');
            $table->string('value');
            $table->smallInteger('order')->unsigned()->default(1);
            $this->commonColumns($table);
        });

        Schema::create('medical_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id')->index();
            $table->foreign('question_id')->references('id')->on('medical_questions');
            $table->unsignedBigInteger('visit_id')->index();
            $table->foreign('visit_id')->references('id')->on('medical_visits');
            $table->longText('answer_text')->nullable();
            $table->json('answer_key')->nullable(); //array of keys for radio, checkbox, select
            $this->commonColumns($table);
        });

    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_answers');
        Schema::dropIfExists('medical_question_options');
        Schema::dropIfExists('medical_questions');
        Schema::dropIfExists('medical_sections');
        Schema::dropIfExists('medical_forms');
        Schema::dropIfExists('medical_question_types');
        Schema::dropIfExists('medical_prescription_items');
        Schema::dropIfExists('medical_prescriptions');
        Schema::dropIfExists('medical_medicines');
        Schema::dropIfExists('medical_medicine_types');
        Schema::dropIfExists('medical_visits_services');
        Schema::dropIfExists('medical_services');
        Schema::dropIfExists('medical_visits');
        Schema::dropIfExists('medical_allergies');
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'clinic_id')) {
                $table->dropForeign(['clinic_id']);
                $table->dropColumn('clinic_id');
            }
        });
        Schema::dropIfExists('medical_patients');
        Schema::dropIfExists('medical_clinics');
        Schema::dropIfExists('medical_villages');
        Schema::dropIfExists('medical_cities');
    }

    protected function commonColumns(Blueprint $table): void
    {
        $table->text('properties')->nullable();
        $table->auditable();
        $table->softDeletes();
        $table->timestamps();
    }
}